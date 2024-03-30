<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function showProfilePicture()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Check if the user is authenticated and has a profile picture
        if (!$user || !$user->profile_picture) {
            abort(404);
        }

        // Construct the path to the profile picture
        $profilePicturePath = 'profile_pictures/' . $user->profile_picture;

        // Check if the file exists
        if (!Storage::exists($profilePicturePath)) {
            abort(404);
        }

        // Serve the image
        return response()->file(storage_path('app/' . $profilePicturePath));
    }
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

        if ($request->file('profile_picture')) {
            $request->validate([
                'profile_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // $profilePicturePath = $request->file('profile_picture')->store('public/profile_pictures');
            $profilePicturePath = request()->file('profile_picture')->store('profile_pictures', 'public');
            // $request->file->move(public_path('profile_picture'), $request->user()->profile_picture);
            // error_log($profilePicturePath);

            if ($request->user()->profile_picture) {
                Storage::delete($request->user()->profile_picture);
            }

            $request->user()->profile_picture = $profilePicturePath;
        }

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
}
