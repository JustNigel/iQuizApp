<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeactivateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;   

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
        $user = Auth::user();

        // Return the profile view based on user type
        if ($user->type_name === 'student') {
            return view('profile.profile', compact('user'));
        } elseif ($user->type_name === 'trainer') {
            return view('profile.profile', compact('user'));
        } elseif ($user->type_name === 'admin') {
            return view('profile.profile', compact('user'));
        }

        // Default to a general profile page if needed
        return view('profile.profile', compact('user'));
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

        return Redirect::route('profile')->with('status', 'profile-updated');
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

    public function updateProfileImage(Request $request)
    {
        // Validate the cropped image
        $request->validate([
            'cropped_image' => 'required|string',
        ]);

        $user = Auth::user();

        // Get the cropped image data from the request
        $imageData = $request->input('cropped_image');

        // Decode the Base64 string into binary data
        $image = str_replace('data:image/jpeg;base64,', '', $imageData);
        $image = str_replace(' ', '+', $image);
        $imageName = time() . '.jpg';

        // Store the image in the profiles folder
        File::put(public_path('images/profiles/') . $imageName, base64_decode($image));

        // Save the image path in the database
        $user->image_profile = $imageName;
        $user->save();

    
        return Redirect::route('profile')->with('success', 'Profile image updated successfully!');
    }


    public function deactivate(DeactivateRequest $request)
    {
        $user = Auth::user();
        User::find($user->id)->delete();
        Auth::logout();
        return redirect(route('login'));
    }
    
}