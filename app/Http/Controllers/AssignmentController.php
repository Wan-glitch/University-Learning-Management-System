<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AssignmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'due_time' => 'required',
            'files.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx'
        ]);

        $task = new Task();
        $task->course_id = $request->course_id;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->due_date = $request->due_date . ' ' . $request->due_time;
        $task->save();

        if($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('courses/'.$task->course_id, 'public');
                $task->files()->create(['path' => $path]);
            }
        }

        // Assign task to all students in the course
        $course = Course::find($request->course_id);
        foreach ($course->students as $student) {
            $student->tasks()->attach($task->id, ['status' => 'Assigned']);
        }

        return redirect()->route('courses.assignments', ['course' => $request->course_id])->with('success', 'Assignment created successfully.');
    }

    public function show(Course $course, $id)
    {
        try {
            $assignment = Task::findOrFail($id);
            $user = Auth::user();
            $submission = $assignment->users()->where('user_id', $user->id)->first();
            return view('courses.assignments.show', compact('assignment', 'submission'));
        } catch (\Exception $e) {
            Log::error('Error fetching assignment details: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while fetching the assignment details.'], 500);
        }
    }

    public function submit(Request $request, Course $course, $id)
    {
        Log::info('Submit assignment: start');

        $request->validate([
            'files.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,mp4,mov,avi,wmv|max:20000'
        ]);

        try {
            $user = Auth::user();
            $assignment = Task::findOrFail($id);
            Log::info('Assignment found: ' . $assignment->id);

            $files = [];
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $path = $file->store('submissions');
                    $files[] = $path;
                    Log::info('File uploaded: ' . $path);
                }
            }

            $user->tasks()->updateExistingPivot($assignment->id, [
                'submission_date' => now(),
                'status' => 'submitted',
                'files' => json_encode($files)
            ]);

            Log::info('Assignment submission updated for user: ' . $user->id);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error submitting assignment: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while submitting the assignment.'], 500);
        }
    }
}
