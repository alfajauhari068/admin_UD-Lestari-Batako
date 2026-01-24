<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Toggle dark mode preference for the current user (or session fallback)
     */
    public function toggleDarkMode(Request $request)
    {
        $user = $request->user();
        if ($user) {
            if (array_key_exists('dark_mode', $user->getAttributes())) {
                $user->dark_mode = !$user->dark_mode;
                $user->save();
                return response()->json(['dark_mode' => (bool)$user->dark_mode]);
            }
        }

        // session fallback
        $current = session('dark_mode', false);
        session(['dark_mode' => !$current]);
        return response()->json(['dark_mode' => !$current]);
    }

    
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
