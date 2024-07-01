<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Course;
use App\Models\Faculty;
use App\Models\Bulletin;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $title = "Dashboard";
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
        // Sample data for the cards
        $usersCount = User::count();
        $Roles = Role::count();  // Replace with your actual data
        $FacultyCount = Faculty::count();    // Replace with your actual data
        $courseCount = Course::count();       // Replace with your actual data

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
        return view('admin.dashboard', compact('usersCount','bulletins','user', 'Roles', 'FacultyCount', 'courseCount','months', 'facultyNames', 'facultyCounts'));
    }
}
