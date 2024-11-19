<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\Presentation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ConferenceRoom;

class PresentationController extends Controller
{
    // Show the form to create a new presentation
    public function create()
{
    // Get all conferences to populate the dropdown
    $conferences = Conference::all();
    return view('presentations.create', compact('conferences'));
}

    // Register a new presentation for a conference
    public function store(Request $request)
{
    $validated = $request->validate([
        'conference_id' => 'required|exists:conferences,id',  // Ensure a valid conference is selected
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'start_time' => 'required|date',
        'end_time' => 'required|date|after:start_time',
    ]);

    // Create the presentation with status 'pending'
    Presentation::create([
        'title' => $validated['title'],
        'description' => $validated['description'],
        'start_time' => $validated['start_time'],
        'end_time' => $validated['end_time'],
        'conference_id' => $validated['conference_id'],
        'user_id' => auth()->id(),
        'status' => 'pending',  // Set the initial status to pending
    ]);

    return redirect()->route('conferences.show', $validated['conference_id'])
        ->with('success', 'Your presentation has been submitted for approval!');
}

    // Manage presentations for the conference
    public function manage($conference_id)
    {
        // Fetch the conference
        $conference = Conference::with('rooms')->findOrFail($conference_id);



        // Ensure that the user is authorized (conference creator or admin)
        if (auth()->id() !== $conference->user_id && Auth::user()->role !== 'admin') {
            return redirect()->route('conferences.show', $conference_id)
                ->with('error', 'You are not authorized to manage presentations.');
        }

        // Fetch all pending presentations for the conference
        $presentations = $conference->presentations()->get();;

        return view('presentations.manage', compact('conference', 'presentations'));
    }

    // Approve and assign room to a presentation
    public function approve(Request $request, $presentationId)
{
    $presentation = Presentation::findOrFail($presentationId);

    // Validate the room_id and timeslot
    $validated = $request->validate([
        'room_id' => 'required|exists:rooms,id',
        'start_time' => 'required|date',
        'end_time' => 'required|date|after:start_time',
    ]);

    // Assign room and timeslot
    $presentation->conference->rooms()->syncWithoutDetaching([
        $validated['room_id'] => [
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
        ],
    ]);

    // Update the presentation status to 'approved'
    $presentation->status = 'approved';
    $presentation->room_id = $validated['room_id']; // Save the room_id directly to the presentation model
    $presentation->save();

    // Return JSON response
    return response()->json([
        'id' => $presentation->id,
        'title' => $presentation->title,
        'speaker' => $presentation->user->name,
        'room' => $presentation->room->name,
        'start_time' => $presentation->start_time,
        'end_time' => $presentation->end_time,
        'status' => $presentation->status,
    ]);
}
public function edit($id)
{
    $presentation = Presentation::findOrFail($id);
    $conference = $presentation->conference; // Fetch the associated conference
    $rooms = $conference->rooms; // Fetch all rooms for the conference

    return view('presentations.edit', compact('presentation', 'conference', 'rooms'));
}

public function update(Request $request, $id)
{
    $presentation = Presentation::findOrFail($id);

    // Validate the request
    $validated = $request->validate([
        'room_id' => 'required|exists:rooms,id',
        'start_time' => 'required|date',
        'end_time' => 'required|date|after:start_time',
    ]);

    // Update the presentation
    $presentation->update([
        'room_id' => $validated['room_id'],
        'start_time' => $validated['start_time'],
        'end_time' => $validated['end_time'],
    ]);

    return redirect()->route('presentations.manage', $presentation->conference_id)
        ->with('success', 'Presentation updated successfully!');
}



}
