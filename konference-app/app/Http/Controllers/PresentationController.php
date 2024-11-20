<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\Presentation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ConferenceRoom;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        'user_id' => Auth::id(),
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
        if (Auth::user()->id !== $conference->user_id && Auth::user()->role !== 'admin') {
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

    $roomId = $validated['room_id'];
    $startTime = $validated['start_time'];
    $endTime = $validated['end_time'];

    // Check for conflicts with other presentations in the same room
    $conflicts = Presentation::where('room_id', $roomId)
        ->where('status', 'approved') // Only check for approved presentations
        ->where(function ($query) use ($startTime, $endTime) {
            $query->whereBetween('start_time', [$startTime, $endTime])
                  ->orWhereBetween('end_time', [$startTime, $endTime])
                  ->orWhere(function ($query) use ($startTime, $endTime) {
                      $query->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                  });
        })
        ->exists();

    if ($conflicts) {
        return redirect()->back()->with('error', 'The selected room is already booked for another presentation during this time.');
    }

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
    $presentation->start_time = $validated['start_time'];
    $presentation->end_time = $validated['end_time'];
    $presentation->save();

    return redirect()->back()->with('success', 'Presentation approved successfully.');
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
    $roomId = $validated['room_id'];
    $startTime = $validated['start_time'];
    $endTime = $validated['end_time'];
    $presentationConflicts = Presentation::where('room_id', $roomId)
        ->where('status', 'approved') // Only check for approved presentations
        ->where('id', '!=', $presentation->id)
        ->where(function ($query) use ($startTime, $endTime) {
            $query->whereBetween('start_time', [$startTime, $endTime])
                  ->orWhereBetween('end_time', [$startTime, $endTime])
                  ->orWhere(function ($query) use ($startTime, $endTime) {
                      $query->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                  });
        })
        ->exists();

    // $roomConflicts = DB::table('conference_room')
    // ->where('room_id', $roomId)
    // ->where(function ($query) use ($startTime, $endTime) {
    //     $query->where('start_time', '>', $startTime) // Requested start time is before the room's start time
    //           ->orWhere('end_time', '<', $endTime); // Requested end time is after the room's end time
    // })
    // ->exists();

    // Return error if any conflict is detected
    if ($presentationConflicts ) {
        return redirect()->back()->with('error', 'The selected room is already booked during this time.');
    }

    return redirect()->route('presentations.manage', $presentation->conference_id)
        ->with('success', 'Presentation updated successfully!');
}
    public function timetable(Request $request)
    {
        // Determine the current week's starting date (default to today if no date provided)
        $currentDate = $request->query('date') 
            ? Carbon::parse($request->query('date')) 
            : Carbon::now();
    
        // Calculate the start and end of the week independently
        $startOfWeek = $currentDate->copy()->startOfWeek(); // Start of the week (Monday)
        $endOfWeek = $currentDate->copy()->endOfWeek();    // End of the week (Sunday)
    
        // Get the user's presentations within the week's range
        $presentations = Presentation::where('user_id', auth()->id())
            ->whereBetween('start_time', [$startOfWeek, $endOfWeek])
            ->orderBy('start_time')
            ->get();
    
        // Format dates for view purposes
        $formattedStartOfWeek = $startOfWeek->format('F j, Y');
        $formattedEndOfWeek = $endOfWeek->format('F j, Y');
    
        return view('presentations.timetable', compact(
            'presentations',
            'startOfWeek',
            'endOfWeek',
            'formattedStartOfWeek',
            'formattedEndOfWeek'
        ));
    }



}
