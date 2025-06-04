<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Untuk menghapus file lama

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('eventCategory')->latest('start_date'); // Menampilkan yang terbaru dulu atau 'start_date', 'desc'
        $events = $query->paginate(15);
        // Ganti 'admin.events.index' dengan path view panitia, misal 'committee.events.index'
        return view('committee.events.index', compact('events')); 
    }

    public function create()
    {
        $categories = EventCategory::orderBy('name')->get();
        // Ganti 'admin.events.create' dengan path view panitia, misal 'committee.events.create'
        return view('committee.events.create', compact('categories')); 
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date', // Atau datetime
            'end_date' => 'required|date|after_or_equal:start_date', // Atau datetime
            'event_category_id' => 'required|integer|exists:event_categories,id',
            'lokasi' => 'required|string|max:255',
            'narasumber' => 'required|string|max:255',
            'poster_kegiatan' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'biaya_registrasi' => 'required|numeric|min:0',
            'jumlah_maksimal_peserta' => 'required|integer|min:1',
        ]);

        if ($request->hasFile('poster_kegiatan')) {
            $path = $request->file('poster_kegiatan')->store('event_posters', 'public');
            $validatedData['poster_kegiatan'] = $path;
        }

        Event::create($validatedData);

        // Ganti 'events.index' dengan nama rute panitia, misal 'committee.events.index'
        return redirect()->route('committee.events.index')->with('success', 'Event berhasil dibuat.');
    }

    public function show(Event $event)
    {
        $event->load('eventCategory', 'eventRegistrations.user', 'eventRegistrations.status');
        // Ganti 'admin.events.show' dengan path view panitia, misal 'committee.events.show'
        return view('committee.events.show', compact('event')); 
    }

    public function edit(Event $event)
    {
        $categories = EventCategory::orderBy('name')->get();
        // Ganti 'admin.events.edit' dengan path view panitia, misal 'committee.events.edit'
        return view('committee.events.edit', compact('event', 'categories')); 
    }

    public function update(Request $request, Event $event)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'event_category_id' => 'required|integer|exists:event_categories,id',
            'lokasi' => 'required|string|max:255',
            'narasumber' => 'required|string|max:255',
            'poster_kegiatan' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'biaya_registrasi' => 'required|numeric|min:0',
            'jumlah_maksimal_peserta' => 'required|integer|min:1',
        ]);

        if ($request->hasFile('poster_kegiatan')) {
            // Hapus poster lama jika ada dan jika poster baru diupload
            if ($event->poster_kegiatan) {
                Storage::disk('public')->delete($event->poster_kegiatan);
            }
            $path = $request->file('poster_kegiatan')->store('event_posters', 'public');
            $validatedData['poster_kegiatan'] = $path;
        }

        $event->update($validatedData);

        // Ganti 'events.index' dengan nama rute panitia, misal 'committee.events.index'
        return redirect()->route('committee.events.index')->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        // Hapus file poster terkait jika ada
        if ($event->poster_kegiatan) {
            Storage::disk('public')->delete($event->poster_kegiatan);
        }
        
        $event->delete();
        // Ganti 'events.index' dengan nama rute panitia, misal 'committee.events.index'
        return redirect()->route('committee.events.index')->with('success', 'Event berhasil dihapus.');
    }
}