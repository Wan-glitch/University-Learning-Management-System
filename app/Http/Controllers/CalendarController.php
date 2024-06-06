<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('calendar.index', compact('events'));
    }

    public function store(Request $request)
    {
        $event = new Event();
        $event->title = $request->title;
        $event->date = $request->date;
        $event->time = $request->time;
        $event->color = $request->color;
        $event->tag = $request->tag;
        $event->save();

        return response()->json(['success' => 'Event created successfully.']);
    }

    public function destroy($id)
    {
        Event::destroy($id);
        return response()->json(['status' => 'success']);
    }
}
