<?php

namespace App\Providers;

use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Http\View\Composers\ProfileComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        View::composer('*', ProfileComposer::class);
        View::composer('*', function ($view) {
            // Check if a user is authenticated before attempting to access their courses
            if (Auth::check()) {
                $user = Auth::user();
                $courses = $user->courses; // Assuming the User model has a relationship with Course
                $view->with('courses', $courses);
            } else {
                $view->with('courses', collect()); // Provide an empty collection if no user is authenticated
            }
        });
    }
}
