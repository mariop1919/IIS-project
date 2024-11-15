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
    public function create($conference_id)
    {
        $conference = Conference::findOrFail($conference_id);
        return view('presentations.create', compact('conference'));
    }

    // Register a new presentation for a conference
    public function register(Request $request, $conference_id)
    {
        $validated = $request->validate([
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
            'conference_id' => $conference_id,
            'user_id' => auth()->id(),
            'status' => 'pending',  // Set the initial status to pending
        ]);

        return redirect()->route('conferences.show', $conference_id)
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
        $presentations = $conference->presentations()->where('status', 'pending')->get();

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

    // Update presentation status to 'approved'
    $presentation->status = 'approved';
    $presentation->save();

    return redirect()->route('conferences.show', $presentation->conference->id)
        ->with('success', 'Presentation approved and room assigned.');
}

}
