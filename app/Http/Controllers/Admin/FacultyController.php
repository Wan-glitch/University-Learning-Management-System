<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Course;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class FacultyController extends Controller
{
    public function index()
    {
        $courses = Course::with('hasFaculty', 'hasPIC')->get();

        \Log::info($courses); // Log the courses data to see if relationships are being loaded
        $faculties = Faculty::all();
        $users = User::all();
        return view('admin.faculties.index', compact('courses', 'faculties', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'pic' => 'nullable|exists:users,id',
        ]);

        $faculty = Faculty::create([
            'title' => $request->title,
            'description' => $request->description,
            'pic' => $request->pic,
            'created_by' => auth()->id(),
        ]);

        if ($request->has('courses')) {
            foreach ($request->courses as $courseId) {
                $course = Course::find($courseId);
                if ($course) {
                    $course->faculty = $faculty->id;
                    $course->save();
                }
            }
        }

        return redirect()->route('admin.faculties.index')->with('success', 'Faculty created successfully.');
    }
    public function update(Request $request, Faculty $faculty)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'pic' => 'nullable|exists:users,id',
        ]);

        $faculty->update([
            'title' => $request->title,
            'description' => $request->description,
            'pic' => $request->pic,
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('admin.faculties.index')->with('success', 'Faculty updated successfully.');
    }

    public function destroy(Faculty $faculty)
    {
        $faculty->delete();
        return redirect()->route('admin.faculties.index')->with('success', 'Faculty deleted successfully.');
    }
}
