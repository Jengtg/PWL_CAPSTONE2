<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('eventCategory')->orderBy('start_date', 'desc');
        // Add filtering/searching if needed, e.g., by category or date
        // if ($request->has('category_id')) {
        //     $query->where('event_category_id', $request->category_id);
        // }
        $events = $query->paginate(15);
        return view('admin.events.index', compact('events')); // Example view
    }

    public function create()
    {
        $categories = EventCategory::orderBy('name')->get();
        return view('admin.events.create', compact('categories')); // Example view
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'event_category_id' => 'required|integer|exists:event_categories,id',
        ]);

        Event::create($request->all());

        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }

    public function show(Event $event)
    {
        $event->load('eventCategory', 'eventRegistrations.user', 'eventRegistrations.status'); // Eager load details
        return view('admin.events.show', compact('event')); // Example view
    }

    public function edit(Event $event)
    {
        $categories = EventCategory::orderBy('name')->get();
        return view('admin.events.edit', compact('event', 'categories')); // Example view
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'event_category_id' => 'required|integer|exists:event_categories,id',
        ]);

        $event->update($request->all());

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        // Cascade delete should handle registrations, certificates etc. if DB constraints are set.
        // Otherwise, you might need to manually delete related data if constraints are not ON DELETE CASCADE
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }
}