<?php

namespace App\Http\Controllers;

use App\Models\karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    //
    public function index()
    {
        $karyawans = Karyawan::all();
        return view('karyawans.dashboard_kariawan', compact('karyawans'));
    }

    public function create()
    {
        return view('karyawans.create_kariawan');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string|max:500',
            
        ]);

        Karyawan::create($validatedData);

        return redirect()->route('karyawans.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        return view('karyawans.Edit_kariawan', compact('karyawan'));
    }

    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255', // Pastikan kolom ini ada di tabel
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string|max:500',
        ]);

        $karyawan->update($validatedData);

        return redirect()->route('karyawans.index')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();
        return redirect()->route('karyawans.index')->with('success', 'Karyawan berhasil dihapus.');
    }
}
