<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use App\Models\Faculty;
use App\Models\Bulletin;
use Illuminate\Http\Request;
use App\Mail\BulletinReminder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Notifications\BulletinNotification;

class BulletinController extends Controller
{
    public function create()
    {
        $faculties = Faculty::all();
        $users = User::all();
        return view('bulletins.create', compact('faculties', 'users'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string',
            'faculty_id' => 'nullable|exists:faculties,id',
            'recipients' => 'nullable|array',
            'recipients.*' => 'exists:users,id',
            'attachments.*' => 'nullable|file|max:10240', // max 10MB per file
        ]);

        // Clean up content to remove empty paragraphs and non-breaking spaces
        $cleanedContent = $this->cleanContent($request->content);

        $bulletin = Bulletin::create([
            'title' => $request->title,
            'content' => $cleanedContent,
            'category' => $request->category,
            'faculty_id' => $request->faculty_id,
            'created_by' => auth()->id(),
        ]);

        if ($request->has('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments', 'public');
                File::create([
                    'user_id' => auth()->id(),
                    'bulletin_id' => $bulletin->id,
                    'file_path' => $path,
                ]);
            }
        }

        if ($request->category == 'Reminder' && $request->has('recipients')) {
            $bulletin->recipients()->attach($request->recipients);
            foreach ($request->recipients as $recipientId) {
                $recipient = User::find($recipientId);
                if ($recipient) {
                    Mail::to($recipient->email)->send(new BulletinReminder($bulletin));
                }
            }
        }

        return redirect()->route('dashboard')->with('success', 'Bulletin created successfully.');
    }


    // Helper function to clean up content
    private function cleanContent($content)
    {
        // Remove empty paragraphs and non-breaking spaces
        $content = preg_replace('/<p>(&nbsp;|\s|<\/?\s?br\s?\/?>)*<\/p>/', '', $content);

        return $content;
    }


    public function edit(Bulletin $bulletin)
    {
        $faculties = Faculty::all();
        $users = User::all();
        return view('bulletin.edit', compact('bulletin', 'faculties', 'users'));
    }


    public function destroy(Bulletin $bulletin)
    {
        $bulletin->delete();
        return redirect()->route('dashboard')->with('success', 'Bulletin deleted successfully.');
    }


    public function getBulletinsByCategory($category)
    {
        $bulletins = Bulletin::where('category', $category)->get();
        return view('bulletin.partials.bulletin_list', compact('bulletins'));
    }

    public function show($id)
    {
        $bulletin = Bulletin::findOrFail($id);
        return view('bulletin.partials.bulletin_detail', compact('bulletin'));
    }



    public function filter(Request $request)
    {
        $category = $request->input('category');
        $facultyId = $request->input('faculty_id');
        $userId = auth()->user()->id;

        $bulletins = Bulletin::when($category == 'Reminder', function($query) use ($userId) {
                $query->whereHas('recipients', function($query) use ($userId) {
                    $query->where('user_id', $userId);
                });
            })
            ->when($category == 'Faculty', function($query) use ($facultyId) {
                $query->where('faculty_id', $facultyId);
            })
            ->when($category == 'Bulletin', function($query) {
                // No additional filtering needed for Bulletins
            })
            ->where('category', $category)
            ->get();

        return view('bulletin.partials.bulletin_list', compact('bulletins'));
    }


}
