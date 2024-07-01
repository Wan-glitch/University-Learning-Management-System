<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Faculty;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        \Log::info($courses); // Log the courses data to see if relationships are being loaded
        $faculties = Faculty::all();
        $users = User::all();
        return view('admin.courses.index', compact('courses', 'faculties', 'users'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'faculty' => 'nullable|exists:faculties,id',
            'pic' => 'nullable|exists:users,id',

            'status' => 'nullable|boolean'
        ]);

        Course::create([
            'name' => $request->name,
            'description' => $request->description,
            'faculty' => $request->faculty,
            'pic' => $request->pic,

            'status' => $request->status ?? 1,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully.');
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'faculty' => 'nullable|exists:faculties,id',
            'pic' => 'nullable|exists:users,id',

            'status' => 'nullable|boolean'
        ]);

        $course->update([
            'name' => $request->name,
            'description' => $request->description,
            'faculty' => $request->faculty,
            'pic' => $request->pic,

            'status' => $request->status ?? 1,
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully.');
    }
}
