<?php

namespace App\Http\Controllers\Admin;

use App\Models\File;
use App\Models\User;
use App\Models\Faculty;
use App\Models\Bulletin;
use Illuminate\Http\Request;
use App\Mail\BulletinReminder;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Notifications\BulletinNotification;

class BulletinController extends Controller
{
    public function index()
    {
        $bulletins = Bulletin::with('faculty', 'createdBy')->paginate(10);
        return view('admin.bulletins.index', compact('bulletins'));
    }

    public function create()
    {
        $faculties = Faculty::all();
        $users = User::all();
        return view('admin.bulletins.create', compact('faculties', 'users'));
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

        if ($request->category == 'Reminder' && $request->has('recipients')) {
            $bulletin->recipients()->attach($request->recipients);
            foreach ($request->recipients as $recipientId) {
                $recipient = User::find($recipientId);
                if ($recipient) {
                    Mail::to($recipient->email)->send(new BulletinReminder($bulletin));
                }
            }
        }

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

        return redirect()->route('admin.bulletins.index')->with('success', 'Bulletin created successfully.');
    }

    private function cleanContent($content)
    {
        // Remove empty paragraphs and non-breaking spaces
        return preg_replace('/<p>(&nbsp;|\s|<\/?\s?br\s?\/?>)*<\/p>/', '', $content);
    }

    public function edit(Bulletin $bulletin)
    {
        $faculties = Faculty::all();
        $users = User::all();
        return view('admin.bulletins.edit', compact('bulletin', 'faculties', 'users'));
    }

    public function update(Request $request, Bulletin $bulletin)
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

        $bulletin->update([
            'title' => $request->title,
            'content' => $cleanedContent,
            'category' => $request->category,
            'faculty_id' => $request->faculty_id,
        ]);

        return redirect()->route('admin.bulletins.index')->with('success', 'Bulletin updated successfully.');
    }

    public function destroy(Bulletin $bulletin)
    {
        $bulletin->delete();
        return redirect()->route('admin.bulletins.index')->with('success', 'Bulletin deleted successfully.');
    }
}
