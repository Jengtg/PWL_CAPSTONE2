<?php

namespace App\Http\Controllers;

use App\Models\EventCategory;
use Illuminate\Http\Request;

class EventCategoryController extends Controller
{
    public function index()
    {
        $categories = EventCategory::orderBy('name')->paginate(15);
        return view('admin.event_categories.index', compact('categories')); // Example view
    }

    public function create()
    {
        return view('admin.event_categories.create'); // Example view
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|unique:event_categories,id', // If manually assigning ID
            'name' => 'required|string|max:255|unique:event_categories,name',
        ]);

        EventCategory::create($request->all());

        return redirect()->route('event-categories.index')->with('success', 'Event category created.');
    }

    public function show(EventCategory $eventCategory)
    {
        return view('admin.event_categories.show', compact('eventCategory')); // Example view
    }

    public function edit(EventCategory $eventCategory)
    {
        return view('admin.event_categories.edit', compact('eventCategory')); // Example view
    }

    public function update(Request $request, EventCategory $eventCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:event_categories,name,' . $eventCategory->id,
        ]);

        $eventCategory->update($request->only('name'));

        return redirect()->route('event-categories.index')->with('success', 'Event category updated.');
    }

    public function destroy(EventCategory $eventCategory)
    {
        // Consider checking if category has events before deleting
        // if ($eventCategory->events()->count() > 0) {
        //     return back()->with('error', 'Cannot delete category with associated events.');
        // }
        $eventCategory->delete();
        return redirect()->route('event-categories.index')->with('success', 'Event category deleted.');
    }
}