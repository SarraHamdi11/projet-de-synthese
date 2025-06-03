<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserProfileController extends Controller
{
    /**
     * Display the user's profile edit form.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nom_uti' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'ville' => ['required', 'string', 'max:255'],
            'date_naissance' => ['required', 'date'],
            'email_uti' => ['required', 'string', 'email', 'max:255', Rule::unique('utilisateurs')->ignore($user->id)],
            'tel_uti' => ['required', 'string', 'max:255'],
            'photodeprofil_uti' => ['nullable', 'image', 'max:1024'], // Max 1MB
        ]);

        if ($request->hasFile('photodeprofil_uti')) {
            // Delete old profile picture if exists
            if ($user->photodeprofil_uti) {
                Storage::disk('public')->delete($user->photodeprofil_uti);
            }

            // Store new profile picture
            $path = $request->file('photodeprofil_uti')->store('profile-photos', 'public');
            $user->photodeprofil_uti = $path;
        }

        $user->nom_uti = $request->nom_uti;
        $user->prenom = $request->prenom;
        $user->ville = $request->ville;
        $user->date_naissance = $request->date_naissance;
        // Only update email if it's changed and validated
        if ($request->email_uti !== $user->email_uti) {
             $user->email_uti = $request->email_uti;
        }
        $user->tel_uti = $request->tel_uti;

        $user->save();

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Display the user's password update form.
     */
    public function showPasswordForm()
    {
        return view('profile.password');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', 'string', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'not_in:current_password'],
        ], [
            'current_password.current_password' => 'The provided password does not match your current password.',
            'password.not_in' => 'The new password cannot be the same as the current password.',
        ]);

        $user->mot_de_passe_uti = Hash::make($request->password);
        $user->save();

        return redirect()->route('profile.password.form')->with('status', 'password-updated');
    }

    /**
     * Display the user's account deletion confirmation form.
     */
    public function showDeleteForm()
    {
        return view('profile.delete');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        // Delete profile picture if exists
        if ($user->photodeprofil_uti) {
            Storage::disk('public')->delete($user->photodeprofil_uti);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('status', 'account-deleted');
    }
}
