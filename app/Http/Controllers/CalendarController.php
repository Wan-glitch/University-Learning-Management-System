<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\EventGuest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\EventInvitation;

class CalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $usersList = User::all();
        return view('calendar.index',compact('usersList'));
    }



    public function store(Request $request)
    {
        $event = Event::create([
            'title' => $request->input('title'),
            'date' => $request->input('date'),
            'time' => $request->input('time'),
            'color' => $request->input('color'),
            'created_by' => auth()->user()->id,
        ]);

        // Get the guest IDs from the hidden input
        $guestIds = array_filter(explode(',', $request->input('TagifyUserListHidden')));

        // Check if there are guest IDs to process
        if (!empty($guestIds)) {
            foreach ($guestIds as $guestId) {
                if (!empty($guestId)) {
                    EventGuest::create([
                        'event_id' => $event->id,
                        'user_id' => $guestId,
                        'status' => 'pending',
                    ]);

                    // Send email notification to each guest
                    $guest = User::find($guestId);
                    if ($guest) {
                        $guest->notify(new EventInvitation($event));
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'Event created successfully and invitations sent!');

    }

    public function events(Request $request)
    {
        if ($request->has('month')) {
            $events = Event::where('created_by', Auth::id())
                ->where('date', 'like', $request->month . '%')
                ->get();
        } else {
            $events = Event::where('created_by', Auth::id())->get();
        }
        return response()->json($events);
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        if ($event->created_by !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $event->delete();

        return response()->json(['success' => 'Event deleted successfully.']);
    }

    public function respond(Request $request)
    {
        $invitation = EventGuest::where('event_id', $request->input('event_id'))
                                ->where('user_id', Auth::id())
                                ->first();

        if ($invitation) {
            $invitation->status = $request->input('response'); // 'accepted', 'rejected'
            $invitation->save();
        }

        return response()->json(['status' => 'success']);
    }
}
