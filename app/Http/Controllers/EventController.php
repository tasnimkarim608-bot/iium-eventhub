<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    // Student: View all events
    public function index()
    {
        $events = Event::all();
        return view('events.index', compact('events'));
    }

    // Student: Register for event (AJAX JSON response)
    public function register($id)
    {
        $event = Event::findOrFail($id);
        $user = Auth::user();
        
        $existing = Registration::where('user_id', $user->id)
            ->where('event_id', $event->id)
            ->first();
            
        if ($existing) {
            return response()->json(['message' => 'You are already registered for this event!'], 200);
        }
        
        $registeredCount = Registration::where('event_id', $event->id)->count();
        if ($registeredCount >= $event->max_slots) {
            return response()->json(['message' => 'Sorry, this event is full!'], 200);
        }
        
        Registration::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'registered_at' => now()
        ]);
        
        return response()->json(['message' => 'Successfully registered for ' . $event->title], 200);
    }

    // Student: Cancel registration (AJAX JSON response)
    public function cancel($id)
    {
        $registration = Registration::where('user_id', auth()->id())
            ->where('event_id', $id)
            ->firstOrFail();
        
        $event = $registration->event;
        $registration->delete();
        
        return response()->json(['message' => 'Successfully cancelled registration for ' . $event->title], 200);
    }

    // Organizer: Dashboard
    public function organizerDashboard()
    {
        $events = Event::where('organiser_id', auth()->id())->get();
        return view('organizer.dashboard', compact('events'));
    }

    // Organizer: Show create form
    public function create()
    {
        return view('organizer.create');
    }

    // Organizer: Store new event
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'venue' => 'required',
            'event_date' => 'required|date',
            'category' => 'required',
            'max_slots' => 'required|integer|min:1',
        ]);

        Event::create([
            'organiser_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'venue' => $request->venue,
            'event_date' => $request->event_date,
            'category' => $request->category,
            'max_slots' => $request->max_slots,
        ]);

        return redirect()->route('organizer.dashboard')->with('success', 'Event created successfully!');
    }

    // Organizer: Show edit form
    public function edit($id)
    {
        $event = Event::where('organiser_id', auth()->id())->findOrFail($id);
        return view('organizer.edit', compact('event'));
    }

    // Organizer: Update event
    public function update(Request $request, $id)
    {
        $event = Event::where('organiser_id', auth()->id())->findOrFail($id);
        
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'venue' => 'required',
            'event_date' => 'required|date',
            'category' => 'required',
            'max_slots' => 'required|integer|min:1',
        ]);

        $event->update($request->all());

        return redirect()->route('organizer.dashboard')->with('success', 'Event updated successfully!');
    }

    // Organizer: Delete event
    public function destroy($id)
    {
        $event = Event::where('organiser_id', auth()->id())->findOrFail($id);
        $event->delete();

        return redirect()->route('organizer.dashboard')->with('success', 'Event deleted successfully!');
    }

    // Organizer: View registrations for an event
    public function viewRegistrations($id)
    {
        $event = Event::where('organiser_id', auth()->id())->findOrFail($id);
        $registrations = $event->registrations()->with('user')->get();
        return view('organizer.registrations', compact('event', 'registrations'));
    }
}