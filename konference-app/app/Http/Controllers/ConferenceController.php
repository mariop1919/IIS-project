<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConferenceController extends Controller
{
    // returns true if the conference has available capacity
    public function checkCapacity($conference)
    {
        return $conference->reservations->count() < $conference->capacity;
    }

    public function index()
    {
        $conferences = Conference::with('reservations')->get(); // Get all conferences with reservations

        // Check capacity for each conference
        foreach ($conferences as $conference) {
            $conference->is_full = !$this->checkCapacity($conference);
        }

        return view('conferences.index', compact('conferences')); // Pass data to the view
    }
    
    public function show($id)
    {
        $conference = Conference::with(['presentations.user', 'presentations.room'])->findOrFail($id);
        $approvedPresentations = $conference->presentations->filter(function ($presentation) {
            return $presentation->status === 'approved'; // Only approved presentations
        });
        

        return view('conferences.detail', compact('conference', 'approvedPresentations'));
    }

    public function create()
    {
        return view('conferences.CreateConference');
    }

    // save to database
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'location' => 'nullable|alpha|max:255', // `nullable` means this field is optional
        'capacity' => 'required|integer|min:1',
        'price' => 'nullable|numeric|min:0',
        'start_time' => 'required|date|after_or_equal:now',
        'end_time' => 'required|date|after:start_time',
    ], [
        'capacity.min' => 'The capacity must be at least 1.',
        'price.min' => 'The price must be at least 0.',
        'start_time.after_or_equal' => 'The conference must start in the future.',
        'end_time.after' => 'The end time must be after the start time.',
    ]);

    // Create the conference
    Conference::create([
        'name' => $validated['name'],
        'location' => $validated['location'],
        'capacity' => $validated['capacity'],
        'price' => $validated['price'] ?? 0.00, // Default to 0.00 if not provided
        'start_time' => $validated['start_time'],
        'end_time' => $validated['end_time'],
        'user_id' => Auth::id(),
    ]);

    return redirect()->route('home')->with('success', 'Conference created successfully!');
}
    
    public function edit($id)
    {
        $conference = Conference::findOrFail($id);
        return view('conferences.edit', compact('conference'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $conference = Conference::findOrFail($id);
        $conference->update($validated);

        return redirect()->route('conferences.show', $conference->id)
            ->with('success', 'Conference updated successfully!');
    }

    public function destroy($id)
    {
        $conference = Conference::findOrFail($id);
        $conference->reservations()->delete();
        $conference->delete();

        return redirect()->route('conferences.index')
            ->with('success', 'Conference deleted successfully!');
    }
}
