<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\Auth\ProviderController;
use App\Http\Controllers\FacultyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth/{provider}/redirect',[ProviderController::class,'redirect']);
Route::get('/auth/{provider}/callback',[ProviderController::class,'callback']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('courses')->group(function () {
        Route::get('/', [CourseController::class, 'index'])->name('courses.index');
        Route::get('programming-fundamentals', [CourseController::class, 'programmingFundamentals'])->name('courses.programming');
        Route::get('machine-learning', [CourseController::class, 'machineLearning'])->name('courses.machine-learning');
        Route::get('web-development', [CourseController::class, 'webDevelopment'])->name('courses.web-development');
    });

    Route::prefix('faculties')->group(function () {
        Route::get('/', [FacultyController::class, 'index'])->name('faculty');
        Route::post('/', [FacultyController::class, 'store'])->name('faculties.store');
    });

    Route::prefix('calendar')->group(function () {
        Route::get('/', [CalendarController::class, 'index'])->name('calendar.index');
        Route::post('/create-event', [CalendarController::class, 'store'])->name('calendar.store');

        Route::delete('/event/{id}', [CalendarController::class, 'destroy'])->name('calendar.destroy');
    });


});




require __DIR__.'/auth.php';
