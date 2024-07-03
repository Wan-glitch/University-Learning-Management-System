<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Comment;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    // Existing store method
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png',
            'video' => 'nullable|mimes:mp4,mov,avi,wmv'
        ]);

        $announcement = new Announcement();
        $announcement->content = $request->input('content');
        $announcement->course_id = $request->input('course_id');
        $announcement->user_id = auth()->id();

        $response = [];

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('attachments', 'public');
            $announcement->attachment = $path;
            $response['attachment'] = $path;
            $response['attachment_name'] = basename($path);
        }

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $announcement->photo = $path;
            $response['photo'] = $path;
            $response['photo_name'] = basename($path);
        }

        if ($request->hasFile('video')) {
            $path = $request->file('video')->store('videos', 'public');
            $announcement->video = $path;
            $response['video'] = $path;
            $response['video_name'] = basename($path);
        }

        $announcement->save();
        return response()->json(array_merge($response, ['success' => 'Announcement sent successfully']));
        // return response()->json($response);
    }

    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();

        return redirect()->back()->with('success', 'Announcement deleted successfully.');
    }


}
