<?php

use App\Models\QrCode;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\BulletinController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\Auth\ProviderController;
use App\Http\Controllers\Admin\SlideshowController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Auth\GoogleSocialiteController;
use App\Http\Controllers\Admin\RoleController as AdminRoleController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\FacultyController as AdminFacultyController;
use App\Http\Controllers\Admin\BulletinController as AdminBulletinController;

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
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
// Route for login
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/courses/{course_id}/start-google-sign-in', function ($course_id) {
    session(['course_id_for_attendance' => $course_id]);
    return redirect()->route('auth.google');
})->name('start-google-sign-in');


Route::get('/auth/{provider}/redirect', [ProviderController::class, 'redirect']);
Route::get('/auth/{provider}/callback', [ProviderController::class, 'callback']);
Route::get('/auth/google', [GoogleSocialiteController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/callback/google', [GoogleSocialiteController::class, 'handleCallback'])->name('callback.google');   // callback route after google account chosen

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {


    Route::get('/bulletins/create', [BulletinController::class, 'create'])->middleware(['auth', 'verified'])->name('bulletins.create');
    Route::post('/bulletins', [BulletinController::class, 'store'])->middleware(['auth', 'verified'])->name('bulletins.store');
    Route::put('/bulletins/{bulletin}', [BulletinController::class, 'update'])->middleware(['auth', 'verified'])->name('bulletins.update');
    Route::delete('/bulletins/{bulletin}', [BulletinController::class, 'destroy'])->middleware(['auth', 'verified'])->name('bulletins.destroy');
    // Route::get('/bulletins/filter', [BulletinController::class, 'filter'])->name('bulletins.filter');
    // Route::get('/bulletins/{bulletin}', [BulletinController::class, 'show'])->middleware(['auth', 'verified'])->name('bulletins.show');

    Route::get('/bulletins/filter', [BulletinController::class, 'filter'])->name('bulletins.filter');

    Route::get('/bulletins/category/{category}', [BulletinController::class, 'getBulletinsByCategory'])->name('bulletins.category');
    Route::get('/bulletins/{id}', [BulletinController::class, 'show'])->name('bulletins.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('courses')->group(function () {
        Route::get('/', [CourseController::class, 'index'])->name('courses.index');

        //Settingg
        Route::get('/{course}/settings', [CourseController::class, 'settings'])->name('course.setting');
        Route::patch('/{course}/settings', [CourseController::class, 'updateSettings'])->name('courses.update-settings');


        //Course Index
        Route::get('/{course}', [CourseController::class, 'show'])->name('courses.show');
        Route::get('/{course}/#', [CourseController::class, 'show'])->name('course.announcements'); // New route for announcements
        Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
        Route::post('/comments', [CommentsController::class, 'store'])->name('comments.store');
        Route::get('/comments/{announcementId}', [CommentsController::class, 'show'])->name('comments.show');
        Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');

        Route::get('/{course}/teaching-plan', [CourseController::class, 'teachingPlan'])->name('course.teachingPlan');
        Route::get('/{course}/modules', [CourseController::class, 'modules'])->name('course.modules');
        Route::get('/{course}/lecturer-info', [CourseController::class, 'lecturersInfo'])->name('course.lecturersInfo');
        // Route::get('/{course}/assignments', [CourseController::class, 'assignments'])->name('course.assignments');

        //Attendance
        Route::get('/{course}/attendance', [CourseController::class, 'attendance'])->name('course.attendance');


        Route::post('/courses/{course}/attendance/activate-qr', [AttendanceController::class, 'activateQR'])->name('activate-qr');
        Route::get('/courses/{course}/attendance/qr', [AttendanceController::class, 'showQR'])->name('attendance.qr');
        Route::get('/courses/{course}/attendance/manual', [AttendanceController::class, 'manualAttendance'])->name('attendance.manual');

        Route::get('courses/{course}/attendance/{qrCode}/details', [AttendanceController::class, 'attendanceDetails'])->name('attendance.details');


        // Route for manual sign-in form
        Route::get('courses/{course}/manual-sign-in', [AttendanceController::class, 'showManualSignInForm'])->name('manual-sign-in');

        // Route for verifying manual attendance
        Route::post('courses/{course}/attendance/verify', [AttendanceController::class, 'verifyManualAttendance'])->name('attendance.verify');
        Route::delete('attendance/{attendance}', [AttendanceController::class, 'deleteAttendance'])->name('attendance.delete');




        //Student
        Route::get('/{course}/students', [CourseController::class, 'students'])->name('course.students');
        Route::post('/{course}/students/add', [CourseController::class, 'addStudent'])->name('course.addStudent');
        Route::delete('/{course}/students/{student}', [CourseController::class, 'removeStudent'])->name('course.removeStudent');

        //UPLOADING
        Route::post('/{course}/upload-lecture', [CourseController::class, 'uploadLecture'])->name('courses.upload-lecture');
        Route::post('/{course}/upload-tutorial', [CourseController::class, 'uploadTutorial'])->name('courses.upload-tutorial');

        //DOWNLOADING
        Route::get('/{course}/{lecture}/download', [CourseController::class, 'downloadLecture'])->name('courses.download-lecture');

        Route::get('{course}/assignments', [CourseController::class, 'assignments'])->name('courses.assignments');
        Route::get('{course}/assignments/{id}', [CourseController::class, 'getAssignment'])->name('courses.assignments.show');
        Route::post('{course}/assignments/create', [CourseController::class, 'createAssignment'])->name('courses.assignments.create');
        Route::put('{course}/assignments/{assignment}', [CourseController::class, 'updateAssignment'])->name('courses.assignments.update');
        Route::delete('{course}/assignments/{assignment}/files/{file}', [CourseController::class, 'deleteFile'])->name('courses.assignments.deleteFile');
        Route::post('{course}/assignments/{assignment}/submit', [CourseController::class, 'submitAssignment'])->name('courses.assignments.submit');
        Route::delete('/assignments/{id}', [CourseController::class, 'destroy'])->name('assignments.destroy');
    });



    Route::prefix('faculties')->group(function () {
        Route::get('/', [FacultyController::class, 'index'])->name('faculty');
        Route::get('/{faculty}', [FacultyController::class, 'detail'])->name('faculty.detail');
        Route::post('/faculties', [FacultyController::class, 'store'])->name('faculties.store');
    });

    Route::prefix('calendar')->group(function () {
        Route::get('/', [CalendarController::class, 'index'])->name('calendar.index');
        Route::post('/create-event', [CalendarController::class, 'store'])->name('calendar.store');
        // Route::get('/events', [CalendarController::class, 'events'])->name('calendar.events');
        Route::get('/event', [CalendarController::class, 'events'])->name('calendar.event');
        Route::delete('/event/{id}', [CalendarController::class, 'destroy'])->name('calendar.destroy');
        Route::post('/event-invitation/response', [CalendarController::class, 'respond'])->name('event-invitation.respond');
        Route::get('/notifications', [CalendarController::class, 'getNotifications'])->name('notifications.index');
        Route::post('/invitation/{id}/{response}', [CalendarController::class, 'respondToInvitation'])->name('calendar.respondInvitation');


    });
    Route::post('/notifications/remove/{id}', [CalendarController::class, 'removeNotification'])->name('notifications.remove');
    Route::post('/notifications/clear', [CalendarController::class, 'clearNotifications'])->name('notifications.clear');

    Route::get('/calendar/events', [CalendarController::class, 'getEvents'])->name('calendar.events');
    // Route::post('/calendar/event/{id}/accept', [CalendarController::class, 'acceptInvitation'])->name('calendar.acceptInvitation');
    // Route::post('/calendar/event/{id}/decline', [CalendarController::class, 'declineInvitation'])->name('calendar.declineInvitation');
    // Route::get('/calendar/invitations', [CalendarController::class, 'showInvitations'])->name('calendar.invitations');




    Route::get('/users/export', [UserController::class, 'export'])->name('users.export');

    Route::get('/get-initial-suggestions', [UserController::class, 'getInitialSuggestions'])->name('get-initial-suggestions');
    Route::get('/get-user', [UserController::class, 'getUser'])->name('get-user');


    Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // Route::prefix('admin')->name('admin.')->group(function () {

        Route::resource('courses', AdminCourseController::class);
        Route::get('courses/filter', [AdminCourseController::class, 'filter'])->name('courses.filter');
        Route::get('/admin-course-suggestion', [AdminCourseController::class, 'getUserSuggestion'])->name('admin-course-suggestion');
        Route::resource('bulletins', AdminBulletinController::class);
        Route::resource('slideshow', SlideshowController::class)->names([
            'index' => 'slideshow.index',
            'create' => 'slideshow.create',
            'store' => 'slideshow.store',
            'edit' => 'slideshow.edit',
            'update' => 'slideshow.update',
            'destroy' => 'slideshow.destroy',

        ]);
        Route::resource('roles', AdminRoleController::class);
        Route::resource('users', AdminUserController::class);
        Route::resource('faculties', AdminFacultyController::class);
        Route::post('faculties/{faculty}/assign-courses', [AdminFacultyController::class, 'assignCourse'])->name('faculties.assign-courses');
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    });

});



require __DIR__ . '/auth.php';
