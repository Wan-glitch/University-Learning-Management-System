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
        $UserList = User::all();
        return view('calendar.index',compact('UserList'));
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

        $guestIds = json_decode($request->input('TagifyUserList'));

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
    public function getEvents(Request $request)
    {
        $month = $request->input('month');

        // Validate the month input
        if (!$month || !preg_match('/^\d{4}-\d{2}$/', $month)) {
            return response()->json(['error' => 'Invalid month format.'], 400);
        }

        // Fetch events for the specified month
        $events = Event::whereYear('date', substr($month, 0, 4))
            ->whereMonth('date', substr($month, 5, 2))
            ->get();

        return response()->json($events);
    }
    /**
     * Accepts an invitation to an event.
     *
     * @param int $id The ID of the event invitation.
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page with a success message.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If no invitation is found for the given ID and user.
     */
    public function acceptInvitation($id)
    {
        // Find the invitation for the given event ID and user ID
        $invitation = EventGuest::where('event_id', $id)
                                ->where('user_id', Auth::id())
                                ->firstOrFail();
        $invitation->update(['status' => 'accepted']);

        return redirect()->back()->with('success', 'You have accepted the invitation.');
    }

    public function declineInvitation($id)
    {
        $invitation = EventGuest::where('event_id', $id)
                                ->where('user_id', Auth::id())
                                ->firstOrFail();
        $invitation->update(['status' => 'declined']);

        return redirect()->back()->with('success', 'You have declined the invitation.');
    }

    public function showInvitations()
    {
        $invitations = EventGuest::where('user_id', auth()->id())->with('event')->get();
        return view('calendar.invitations', compact('invitations'));
    }
    public function getNotifications()
    {
        $notifications = EventGuest::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->with(['event.creator', 'user']) // Eager load the event creator
            ->get();

        return response()->json($notifications);
    }

    public function respondToInvitation($id, $response)
    {
        $invitation = EventGuest::where('event_id', $id)->where('user_id', auth()->id())->firstOrFail();
        $invitation->update(['status' => $response]);

        return response()->json(['success' => 'Invitation ' . $response . ' successfully']);
    }

    public function removeNotification($id)
    {
        $notification = EventGuest::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $notification->delete();

        return response()->json(['success' => 'Notification removed successfully']);
    }

    public function clearNotifications()
    {
        EventGuest::where('user_id', auth()->id())->where('status', 'pending')->delete();

        return response()->json(['success' => 'All notifications cleared']);
    }
}
