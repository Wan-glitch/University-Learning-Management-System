<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => auth()->user(),
        ]);
    }



    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->fill($request->validated());

        // Handle email change
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Handle notification preference
        $user->notify_bulletins = $request->boolean('notify_bulletins');

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old profile photo if it exists
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            // Store new profile photo
            $photo = $request->file('profile_photo');
            $path = $photo->store('profile_photos', 'public');

            // Resize the photo using GD library
            $this->resizeImage(storage_path("app/public/{$path}"), 160, 160);

            $user->profile_photo_path = $path;
        }

        // Debugging
        Log::info('Updating user: ', $user->toArray());

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Resize image to given width and height using GD library.
     *
     * @param string $filePath
     * @param int $width
     * @param int $height
     * @return void
     */
    private function resizeImage(string $filePath, int $width, int $height): void
    {
        list($originalWidth, $originalHeight) = getimagesize($filePath);
        $newImage = imagecreatetruecolor($width, $height);

        $image = imagecreatefromstring(file_get_contents($filePath));

        // Resize and crop
        imagecopyresampled(
            $newImage,
            $image,
            0, 0, 0, 0,
            $width, $height,
            $originalWidth, $originalHeight
        );

        // Save the new image
        switch (mime_content_type($filePath)) {
            case 'image/jpeg':
                imagejpeg($newImage, $filePath);
                break;
            case 'image/png':
                imagepng($newImage, $filePath);
                break;
            case 'image/gif':
                imagegif($newImage, $filePath);
                break;
        }

        imagedestroy($newImage);
        imagedestroy($image);
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
