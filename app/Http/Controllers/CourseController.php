<?php

namespace App\Http\Controllers;

use Log;
use App\Models\File;
use App\Models\Task;
use App\Models\User;
use App\Models\Course;
use App\Models\QrCode;
use App\Models\Lecture;
use App\Models\Lecturer;
use App\Models\Tutorial;
use App\Models\Attendance;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = "Courses";

        $user = auth()->user();
        $courses = $user->courses; // Assuming the User model has a relationship with Course
        // $tasks = Task::whereHas('users', function ($query) use ($user) {
        //     $query->where('user_id', $user->id);
        // })->get();
        // $tasks = Task::whereIn('course_id', $courses->pluck('id'))->get()->groupBy('course.name');
        $tasks = Task::whereIn('course_id', $courses->pluck('id'))
            ->whereDoesntHave('submissions', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->get()
            ->groupBy('course.name');

        $picCourses = Course::where('pic', $user->id)->get();

        return view('courses.index', compact('title', 'courses', 'tasks', 'picCourses'));
    }

    public function show(Course $course)
    {
        $title = $course->name;
        $user = auth()->user();
        $courses = $user->courses; // Assuming the User model has a relationship with Course

        $tasks = $course->tasks()
            ->whereDoesntHave('submissions', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orderby('due_date', 'asc')
            ->get();

        $announcements = Announcement::where('course_id', $course->id)->with('user')->latest()->get();

        return view('courses.show', compact('title', 'course', 'tasks', 'courses', 'announcements'));
    }




    public function teachingPlan(Course $course)
    {
        $title = $course->name;
        $user = auth()->user();
        $courses = $user->courses; // Assuming the User model has a relationship with Course
        // $tasks = Task::whereHas('users', function ($query) use ($user) {
        //     $query->where('user_id', $user->id);
        // })->get();
        $tasks = $course->tasks()
            ->whereDoesntHave('submissions', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orderby('due_date', 'asc')
            ->get();

        return view('courses.teaching_plan', compact('title', 'course', 'tasks', 'courses'));
    }

    public function modules(Course $course)
    {
        $title = $course->name;
        $user = auth()->user();
        $courses = $user->courses; // Assuming the User model has a relationship with Course
        // $tasks = Task::whereHas('users', function ($query) use ($user) {
        //     $query->where('user_id', $user->id);
        // })->get();
        $tasks = $course->tasks()
            ->whereDoesntHave('submissions', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orderby('due_date', 'asc')
            ->get();

        // Load lectures and tutorials relationships
        $course->load('lectures', 'tutorials');

        return view('courses.modules', compact('title', 'course', 'tasks', 'courses'));
    }


    public function lecturersInfo(Course $course)
    {
        $title = $course->name;
        $user = auth()->user();
        $courses = $user->courses; // Assuming the User model has a relationship with Course
        // $tasks = Task::whereHas('users', function ($query) use ($user) {
        //     $query->where('user_id', $user->id);
        // })->get();
        $tasks = $course->tasks()
            ->whereDoesntHave('submissions', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orderby('due_date', 'asc')
            ->get();

        $lecturer = User::find($course->pic);



        return view('courses.lecturer_info', compact('title', 'course', 'tasks', 'courses', 'lecturer'));
    }


    public function assignments(Course $course)
    {
        $title = $course->name;
        $user = auth()->user();
        $courses = $user->courses; // Assuming the User model has a relationship with Course
        $assignments = Task::where('course_id', $course->id)
            ->orderBy('due_date', 'desc')
            ->get(); // Assuming Task represents assignments
        return view('courses.assignments', compact('title', 'course', 'assignments', 'courses'));
    }

    public function createAssignment(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'due_time' => 'required',
            'files.*' => 'sometimes|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:2048'
        ]);

        $dueDateTime = $request->due_date . ' ' . $request->due_time;

        $task = Task::create([
            'course_id' => $course->id,
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $dueDateTime,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filePath = $file->store('assignments/' . $course->id . '/' . $task->id, 'public');
                File::create([
                    'user_id' => auth()->id(),
                    'task_id' => $task->id,
                    'file_path' => $filePath
                ]);
            }
        }

        return redirect()->route('courses.assignments', $course->id)->with('success', 'Assignment created successfully.');
    }

    public function getAssignment(Course $course, $id)
    {
        try {
            $assignment = Task::where('course_id', $course->id)->with('files')->findOrFail($id);
            $assignment->files = $assignment->files->map(function ($file) {
                $file->url = Storage::url($file->file_path);
                $file->name = basename($file->file_path);
                return $file;
            });

            $isPersonInCharge = $course->pic == auth()->id();

            // Get submissions data
            $submissions = DB::table('task_user')
                ->where('task_id', $assignment->id)
                ->join('users', 'task_user.user_id', '=', 'users.id')
                ->select('users.name as user_name', 'task_user.submission_date', 'task_user.files')
                ->get()
                ->map(function ($submission) {
                    $submission->files = json_decode($submission->files, true); // Decode JSON to array
                    if (is_array($submission->files)) {
                        foreach ($submission->files as &$file) {
                            if (isset($file['file_path'])) {
                                $file['url'] = Storage::url($file['file_path']);
                                $file['name'] = basename($file['file_path']);
                            }
                        }
                    } else {
                        $submission->files = [];
                    }
                    return $submission;
                });

            return response()->json([
                'assignment' => $assignment,
                'isPersonInCharge' => $isPersonInCharge,
                'submissions' => $submissions
            ]);
        } catch (\Exception $e) {

            return response()->json(['error' => 'An error occurred'], 500);
        }
    }




    public function updateAssignment(Request $request, Course $course, Task $assignment)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'due_time' => 'required',
            'files.*' => 'sometimes|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:2048'
        ]);

        $dueDateTime = $request->due_date . ' ' . $request->due_time;

        $assignment->update([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $dueDateTime,
            'updated_by' => auth()->id(),
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filePath = $file->store('assignments/' . $course->id . '/' . $assignment->id, 'public');
                File::create([
                    'user_id' => auth()->id(),
                    'task_id' => $assignment->id,
                    'file_path' => $filePath
                ]);
            }
        }

        return redirect()->route('courses.assignments', $course->id)->with('success', 'Assignment updated successfully.');
    }


    // public function submitAssignment(Request $request, Course $course, Task $assignment)
    // {
    //     $request->validate([
    //         'submission_files.*' => 'sometimes|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:2048'
    //     ]);

    //     $submissionDate = now();
    //     $filePaths = [];

    //     if ($request->hasFile('submission_files')) {
    //         foreach ($request->file('submission_files') as $file) {
    //             $filePath = $file->store('submissions/' . $course->id . '/' . $assignment->id, 'public');
    //             $filePaths[] = $filePath;
    //         }
    //     }

    //     // Update the task_user table
    //     DB::table('task_user')->updateOrInsert(
    //         ['task_id' => $assignment->id, 'user_id' => auth()->id()],
    //         [
    //             'submission_date' => $submissionDate,
    //             'status' => 'submitted',
    //             'files' => json_encode($filePaths),
    //             'updated_at' => now()
    //         ]
    //     );

    //     return back()->with('success', 'Assignment submitted successfully.');
    // }
    public function submitAssignment(Request $request, Course $course, Task $assignment)
    {
        $request->validate([
            'submission_files.*' => 'file|mimes:pdf,jpg,jpeg,png|max:2048', // Adjust validation rules as needed
        ]);

        $user = auth()->user();
        $submissionDate = now();
        $filePaths = [];

        if ($request->hasFile('submission_files')) {
            foreach ($request->file('submission_files') as $file) {
                $path = $file->store('submissions/' . $assignment->id, 'public');
                $filePaths[] = [
                    'file_path' => $path,
                ];
            }
        }

        DB::table('task_user')->updateOrInsert(
            ['task_id' => $assignment->id, 'user_id' => $user->id],
            [
                'submission_date' => $submissionDate,
                'status' => 'submitted',
                'files' => json_encode($filePaths),
                'updated_at' => now(),
            ]
        );

        return redirect()->back()->with('success', 'Assignment submitted successfully.');
    }

    public function deleteFile(Course $course, Task $assignment, File $file)
    {
        Storage::delete($file->file_path);
        $file->delete();
        return response()->json(['success' => true]);
    }

    public function attendance(Course $course)
    {
        $title = $course->name;
        $user = auth()->user();
        $courses = $user->courses; // Assuming the User model has a relationship with Course
        $tasks = $course->tasks()
            ->whereDoesntHave('submissions', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orderby('due_date', 'asc')
            ->get();

        // Fetch QR codes associated with the course
        $qrCodes = QrCode::where('course_id', $course->id)->get();

        return view('courses.attendance', compact('title', 'course', 'tasks', 'courses', 'qrCodes'));
    }


    public function students(Course $course)
    {
        $title = $course->name;
        $user = auth()->user();
        $courses = $user->courses; // Assuming the User model has a relationship with Course
        $tasks = $course->tasks()
            ->whereDoesntHave('submissions', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orderby('due_date', 'asc')
            ->get();

        // Fetch students in the same faculty as the lecturer
        $studentsList = User::where('faculty', $user->faculty)
            ->whereNotIn('id', $course->users->pluck('id'))
            ->with('HasFaculty') // Eager load the faculty relationship
            ->get();
        $students = $course->users()->paginate(10);

        return view('courses.students', compact('title', 'course', 'tasks', 'courses', 'students', 'studentsList'));
    }




    public function removeStudent(Course $course, User $student)
    {
        $course->users()->detach($student->id);
        return redirect()->route('course.students', $course)->with('success', 'Student removed from the course successfully.');
    }


    public function addStudent(Request $request, Course $course)
    {
        // Validate the input to ensure 'student_ids' is present and is a string
        $request->validate([
            'student_ids' => 'required|string',
        ]);

        // Decode the JSON string of student IDs
        $studentIds = json_decode($request->input('student_ids'));


        // Retrieve the students based on the decoded IDs
        $students = User::whereIn('id', $studentIds)
        ->where(function ($query) {
            $query->where('role', 'student')
                  ->orWhere('role', '3');
        })
        ->get();

        // Check if all students belong to the same faculty as the lecturer
        foreach ($students as $student) {
            if ($student->HasFaculty->id !== auth()->user()->HasFaculty->id) {
                // Redirect back with an error if any student does not belong to the same faculty
                return redirect()->back()->with('error', 'One or more students do not belong to your faculty.');
            }
        }

        // Attach the students to the course
        $course->users()->attach($students->pluck('id')->toArray());



        // Redirect back to the course students page with a success message
        return redirect()->route('course.students', $course)->with('success', 'Students added to the course successfully.');
    }



    public function uploadLecture(Request $request, Course $course)
    {
        $request->validate([
            'lecture_file' => 'required|file|max:10240', // Example max file size of 10MB
        ]);

        $file = $request->file('lecture_file');
        $fileName = $file->getClientOriginalName();

        $lecture = new Lecture();
        $lecture->name = $fileName;
        $lecture->course_id = $course->id;

        // Store the file and get its path
        $filePath = $file->store('lectures', 'public');
        $lecture->file_path = $filePath;

        $lecture->save();

        return redirect()->back()->with('success', 'Lecture uploaded successfully.');
    }

    public function uploadTutorial(Request $request, Course $course)
    {
        $request->validate([
            'tutorial_file' => 'required|file|max:10240', // Example max file size of 10MB
        ]);

        $file = $request->file('tutorial_file');
        $fileName = $file->getClientOriginalName();

        $tutorial = new Tutorial();
        $tutorial->name = $fileName;
        $tutorial->course_id = $course->id;

        // Store the file and get its path
        $filePath = $file->store('tutorials', 'public');
        $tutorial->file_path = $filePath;

        $tutorial->save();

        return redirect()->back()->with('success', 'Tutorial uploaded successfully.');
    }

    public function downloadLecture(Course $course, Lecture $lecture)
    {
        // Ensure the user is authorized to download the file if necessary

        $filePath = storage_path('app/public/' . $lecture->file_path);

        return response()->download($filePath, $lecture->name);
    }
    public function settings(Course $course)
    {
        return view('courses.settings', compact('course'));
    }

    public function updateSettings(Request $request, Course $course)
    {
        $course->students_can_announce = $request->has('students_can_announce');
        $course->save();

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
