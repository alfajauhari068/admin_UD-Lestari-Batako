<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // These calls require spatie/laravel-permission to be installed.
        if (!class_exists(\Spatie\Permission\Models\Permission::class)) {
            $this->command->warn('Spatie Permission package not installed; skipping PermissionSeeder.');
            return;
        }

        // Define resources and actions to seed common permissions idempotently.
        $resources = [
            'produk',
            'pesanan',
            'pelanggan',
            'karyawan',
            'pengiriman',
            'produksi'
        ];

        $actions = [
            'view',
            'create',
            'edit',
            'delete',
            'export'
        ];

        $permissions = [];
        foreach ($resources as $res) {
            foreach ($actions as $act) {
                $permissions[] = "$act $res";
            }
        }

        // Add any additional standalone permissions if needed
        $permissions[] = 'manage users';

        // Create permissions if they don't exist
        foreach (array_unique($permissions) as $perm) {
            \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        // Create or get admin role and attach all seeded permissions
        $role = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        try {
            $role->givePermissionTo(array_unique($permissions));
        } catch (\Throwable $e) {
            $this->command->warn('Could not assign permissions to admin role: ' . $e->getMessage());
        }

        // assign to first user if exists
        $user = DB::table('users')->orderBy('id')->first();
        if ($user) {
            try {
                $model = \App\Models\User::find($user->id);
                if ($model && method_exists($model, 'assignRole')) {
                    $model->assignRole('admin');
                }
            } catch (\Throwable $e) {
                $this->command->warn('Could not assign role to first user: ' . $e->getMessage());
            }
        }
    }
}
