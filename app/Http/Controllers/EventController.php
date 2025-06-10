<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventCategory;
use App\Models\EventRegister;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Menampilkan daftar event untuk publik/guest.
     */
    public function guestIndex(Request $request)
    {
        // Query untuk mengambil event yang akan datang atau sedang berlangsung
        $query = Event::with('eventCategory')
                      ->where('start_date', '>=', now())
                      ->orderBy('start_date', 'asc');

        // Mengambil semua kategori untuk dropdown filter
        $categories = EventCategory::orderBy('name')->get();

        $events = $query->paginate(9);

        // Mengembalikan view untuk halaman guest
        return view('events.guest-index', compact('events', 'categories'));
    }

    /**
     * Menampilkan detail event untuk publik.
     */
    public function showPublic(Event $event)
    {
        return view('events.show-public', compact('event'));
    }

    /**
     * Menampilkan daftar event untuk panel panitia/admin.
     */
    public function index(Request $request)
    {
        $query = Event::with('eventCategory')->latest('start_date');
        $events = $query->paginate(15);
        return view('committee.events.index', compact('events'));
    }

    /**
     * Menampilkan form untuk membuat event baru.
     */
    public function create()
    {
        $categories = EventCategory::orderBy('name')->get();
        return view('committee.events.create', compact('categories'));
    }

    /**
     * Menyimpan event baru ke database.
     */
    public function store(Request $request)
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
            $path = $request->file('poster_kegiatan')->store('event_posters', 'public');
            $validatedData['poster_kegiatan'] = $path;
        }

        Event::create($validatedData);

        return redirect()->route('committee.events.index')->with('success', 'Event berhasil dibuat.');
    }

    /**
     * Menampilkan detail event di panel panitia/admin.
     */
    public function show(Event $event)
    {
        $event->load('eventCategory', 'eventRegistrations.user', 'eventRegistrations.status');
        return view('committee.events.show', compact('event'));
    }

    /**
     * Menampilkan form untuk mengedit event.
     */
    public function edit(Event $event)
    {
        $categories = EventCategory::orderBy('name')->get();
        return view('committee.events.edit', compact('event', 'categories'));
    }

    /**
     * Memperbarui event di database.
     */
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
            if ($event->poster_kegiatan) {
                Storage::disk('public')->delete($event->poster_kegiatan);
            }
            $path = $request->file('poster_kegiatan')->store('event_posters', 'public');
            $validatedData['poster_kegiatan'] = $path;
        }

        $event->update($validatedData);

        return redirect()->route('committee.events.index')->with('success', 'Event berhasil diperbarui.');
    }

    /**
     * Menghapus event dari database.
     */
    public function destroy(Event $event)
    {
        if ($event->poster_kegiatan) {
            Storage::disk('public')->delete($event->poster_kegiatan);
        }
        
        $event->delete();
        return redirect()->route('committee.events.index')->with('success', 'Event berhasil dihapus.');
    }

    /**
     * Mendaftarkan pengguna yang login ke sebuah event.
     */
    public function register(Request $request, Event $event)
    {
        $user = $request->user();

        // 1. Cek apakah kuota masih tersedia
        $kuotaTerisi = $event->eventRegistrations()->count();
        if ($kuotaTerisi >= $event->jumlah_maksimal_peserta) {
            return back()->with('error', 'Maaf, kuota untuk event ini sudah penuh.');
        }

        // 2. Cek apakah pengguna sudah terdaftar sebelumnya
        $isAlreadyRegistered = EventRegister::where('user_id', $user->id)
                                            ->where('event_id', $event->id)
                                            ->exists();
        
        if ($isAlreadyRegistered) {
            return back()->with('error', 'Anda sudah terdaftar di event ini.');
        }

        // 3. Buat entri registrasi baru
        EventRegister::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'status_id' => 1, // Asumsi status_id 1 = "Menunggu Pembayaran"
            // 'payment_file' akan diisi nanti
        ]);

        // 4. Redirect dengan pesan sukses
        // Jika event berbayar, arahkan ke halaman pembayaran. Jika gratis, langsung konfirmasi.
        if ($event->biaya_registrasi > 0) {
            // Ganti '#' dengan route halaman pembayaran Anda nantinya
            return redirect()->route('home')->with('success', 'Anda berhasil mendaftar! Silakan lanjutkan ke proses pembayaran.');
        } else {
            // Untuk event gratis, Anda bisa langsung update status menjadi lunas
            // atau arahkan ke halaman "Event Saya"
            return redirect()->route('home')->with('success', 'Anda berhasil terdaftar di event gratis ini!');
        }
    }
}
