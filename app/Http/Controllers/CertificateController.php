<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\EventRegister; // To select registration
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index(Request $request)
    {
        $query = Certificate::with(['user', 'event']); // Eager load via simplified relations

        // Example: Filter by event
        if($request->event_id) {
            $query->where('event_register_event_id', $request->event_id);
        }
        // Example: Filter by user
        if($request->user_id) {
            $query->where('event_register_user_id', $request->user_id);
        }

        $certificates = $query->paginate(15);
        return view('admin.certificates.index', compact('certificates')); // Example view
    }

    public function create(Request $request)
    {
        // Fetch event registrations that might not have a certificate yet
        // This logic can be complex
        $registrations = EventRegister::whereDoesntHave('certificates')
                                      ->with(['user','event'])
                                      ->get();
        $selectedRegistrationUserId = $request->query('user_id');
        $selectedRegistrationEventId = $request->query('event_id');

        return view('admin.certificates.create', compact(
            'registrations',
            'selectedRegistrationUserId',
            'selectedRegistrationEventId'
        )); // Example view
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|unique:certificates,id', // If manually assigning ID
            'event_register_user_id' => 'required|integer',
            'event_register_event_id' => 'required|integer',
            // Add unique constraint for (event_register_user_id, event_register_event_id)
            // to ensure one certificate per registration, if that's the rule.
            // Rule::unique('certificates')->where(fn ($query) =>
            //     $query->where('event_register_user_id', $request->event_register_user_id)
            //           ->where('event_register_event_id', $request->event_register_event_id)
            // ),
        ]);

        // Check if EventRegister exists
        $registrationExists = EventRegister::where('user_id', $request->event_register_user_id)
                                           ->where('event_id', $request->event_register_event_id)
                                           ->exists();
        if (!$registrationExists) {
            return back()->withInput()->with('error', 'Invalid event registration selected.');
        }

        // Check if certificate already exists for this registration
        $existingCertificate = Certificate::where('event_register_user_id', $request->event_register_user_id)
                                           ->where('event_register_event_id', $request->event_register_event_id)
                                           ->first();
        if ($existingCertificate) {
             return back()->withInput()->with('error', 'A certificate already exists for this registration.');
        }


        Certificate::create($request->only(['id', 'event_register_user_id', 'event_register_event_id']));

        return redirect()->route('certificates.index')->with('success', 'Certificate created.');
    }

    public function show(Certificate $certificate)
    {
        $certificate->load(['user', 'event']); // Eager load simplified relations
        // $registration = $certificate->eventRegister(); // To get the full registration object
        return view('admin.certificates.show', compact('certificate')); // Example view
    }

    // Edit might not be common for certificates unless you're changing the template or some metadata.
    // public function edit(Certificate $certificate)
    // {
    //     return view('admin.certificates.edit', compact('certificate'));
    // }

    // public function update(Request $request, Certificate $certificate)
    // {
    //     // Validation and update logic
    //     return redirect()->route('certificates.index')->with('success', 'Certificate updated.');
    // }

    public function destroy(Certificate $certificate)
    {
        $certificate->delete();
        return redirect()->route('certificates.index')->with('success', 'Certificate deleted.');
    }
}