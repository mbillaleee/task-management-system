<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
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
     * Delete the user's account.
     */
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

public function updateAccount(Request $request): RedirectResponse
{
    $user = Auth::user();

    // Validation
    $request->validate([
        'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
        'phone' => 'nullable|string|max:20',
        'gender' => 'nullable|string|max:255',
        'date_of_birth' => 'nullable|date',
        'country' => 'nullable|string|max:255',
        'city' => 'nullable|string|max:255',
        'timezone' => 'nullable|string|max:10',
        'bio' => 'nullable|string|max:1000',
        'profile' => 'nullable|image|mimes:jpg,webp,png,jpg,gif,svg|max:2048',
    ]);

    // Update fields
    $user->username = $request->username;
    $user->phone = $request->phone;
    $user->gender = $request->gender;
    $user->date_of_birth = $request->date_of_birth;
    $user->country = $request->country;
    $user->city = $request->city;
    $user->timezone = $request->timezone;
    $user->bio = $request->bio;

    // Handle profile image upload
    if ($request->hasFile('profile')) {
        // Delete old profile if exists
        if ($user->profile && Storage::disk('public')->exists('profile/' . $user->profile)) {
            Storage::disk('public')->delete('profile/' . $user->profile);
        }

        $file = $request->file('profile');
        $name = time() . '_profile.' . $file->getClientOriginalExtension();
        Storage::disk('public')->put('profile/' . $name, File::get($file));
        $user->profile = $name;
    }

    $user->save();

    return Redirect::route('profile.edit')->with('status', 'profile-updated');
}


}
