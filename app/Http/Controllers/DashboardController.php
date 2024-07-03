<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use App\Models\Course;
use App\Models\Faculty;
use App\Models\Bulletin;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $title = "Dashboard";
        // $bulletins = Bulletin::latest()->take(3)->get();
        $user = auth()->user();
        $bulletins = Bulletin::where('category', 'Bulletin')
            ->orWhere(function ($query) use ($user) {
                $query->where('category', 'Reminder')
                    ->whereHas('recipients', function ($query) use ($user) {
                        $query->where('user_id', $user->id);
                    });
            })
            ->orWhere('category', 'Faculty')
            ->where('faculty_id', $user->faculty)
            ->get();


        $faculties = Faculty::all();
        $courses = $user->courses;
        $tasks = Task::whereIn('course_id', $courses->pluck('id'))
        ->whereDoesntHave('submissions', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->get()
        ->groupBy('course.name');
        $usersList = User::select('id', 'name', 'email')->get();
        $users = User::with('HasFaculty')->get();
        $usersCount = User::count();
        $Roles = Role::count();
        $FacultyCount = Faculty::count();
        $courseCount = Course::count();

        // Fetch new users data for the chart (last 12 months)
        $newUsersData = User::selectRaw('COUNT(id) as count, DATE_FORMAT(created_at, "%Y-%m") as month')
                            ->where('created_at', '>=', Carbon::now()->subYear())
                            ->groupBy('month')
                            ->orderBy('month', 'asc')
                            ->get()
                            ->pluck('count', 'month')
                            ->toArray();

        // Ensure all months are present in the data
        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i)->format('Y-m');
            $months->put($month, $newUsersData[$month] ?? 0);
        }

        // Fetch users in each faculty for the donut chart
        $facultyData = User::selectRaw('COUNT(id) as count, faculty')
            ->groupBy('faculty')
            ->pluck('count', 'faculty')
            ->toArray();

        // Get the count of users with no faculty assigned
        $notAssignedCount = User::whereNull('faculty')->count();
        if ($notAssignedCount > 0) {
            $facultyData['Not Assigned'] = $notAssignedCount;
        }

        // Get the faculty names
        $facultyNames = Faculty::pluck('title', 'id')->toArray();
        $facultyNames['Not Assigned'] = 'Not Assigned';

        // Prepare faculty counts, ensuring 'Not Assigned' is included
        $facultyCounts = [];
        foreach ($facultyNames as $id => $name) {
            $facultyCounts[] = $facultyData[$id] ?? 0;
        }
        return view('dashboard', compact('usersCount','Roles','FacultyCount', 'courseCount','months', 'facultyNames', 'facultyCounts','courses','tasks','title','bulletins',   'faculties', 'users', 'usersList'));
    }

    public function admin()
    {
        return view('admin.dashboard');
    }
}
