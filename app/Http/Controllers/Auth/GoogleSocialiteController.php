<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use App\Models\Attendance;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class GoogleSocialiteController extends Controller
{
    public function redirectToGoogle()
    {
        // redirect user to "login with Google account" page
        return Socialite::driver('google')->redirect();
    }

    public function handleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('email', $user->email)->first();

            if ($finduser) {
                $finduser->social_id = $user->id;
                $finduser->social_type = 'google';
                $finduser->save();
                Auth::login($finduser);
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'social_id' => $user->id,
                    'social_type' => 'google',
                    // Use bcrypt for hashing or omit password
                    'password' => bcrypt('my-google'),
                ]);
                Auth::login($newUser);
            }

            $course_id = session('course_id_for_attendance');
            if ($course_id) {
                Attendance::updateOrCreate(
                    [
                        'course_id' => $course_id,
                        'user_id' => Auth::id(),
                        'attendance_date' => date('Y-m-d')
                    ],
                    ['status' => 'present']
                );
                Session::forget('course_id_for_attendance');  // Clear the session variable to prevent reuse
            }

            return redirect()->intended('dashboard');
        } catch (Exception $e) {
            return redirect('auth/google')->withErrors('Unable to login using Google. Please try again.');
        }
    }
}
