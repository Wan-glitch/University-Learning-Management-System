<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'announcement_id' => 'required|exists:announcements,id',
            'content' => 'required'
        ]);

        $comment = new Comment();
        $comment->announcement_id = $request->input('announcement_id');
        $comment->user_id = auth()->id();
        $comment->content = $request->input('content');
        $comment->save();

        return response()->json(['success' => true, 'comment' => $comment]);
    }

    public function show($announcementId)
    {
        $comments = Comment::where('announcement_id', $announcementId)->get();
        return view('courses.comments.show', compact('comments'));
    }
}
