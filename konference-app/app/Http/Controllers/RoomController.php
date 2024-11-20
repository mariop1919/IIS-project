<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\Room;
use App\Models\ConferenceRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    // Zobrazí formulář pro přidání místnosti ke konkrétní konferenci
    public function create()
    {
        // Získá všechny místnosti, které lze přidat ke konferenci
        $user = Auth::user(); // Get the currently authenticated user
        $conferences = Conference::where('user_id', $user->id)
    ->orWhere(function ($query) use ($user) {
        if ($user->role == 'admin') {
            $query->whereNotNull('id'); // Match all conferences if user is an admin
        }
    })
    ->get(); // Fetch user's conferences
        return view('rooms.create', compact('conferences'));
}
    // Uloží novou místnost přidruženou ke konferenci
    public function store(Request $request)
{
    // Validate the input
    $validated = $request->validate([
        'conference_id' => 'required|exists:conferences,id',
        'room_name' => 'required|string|max:255',
        'equipment' => 'required|string|max:255',
    ]);

    // Step 1: Create a new room
    $room = Room::create([
        'name' => $validated['room_name'],
        'equipment' => $validated['equipment'],
    ]);

    // Step 2: Find the conference using the provided conference_id
    $conference = Conference::findOrFail($validated['conference_id']);

    // Step 3: Insert the room and conference relation into the pivot table
    // We're creating a new pivot record here, so we need to attach the room with start_time and end_time from the conference
    $conference->rooms()->attach($room->id, [
        'start_time' => $conference->start_time,  // Get start time from the conference
        'end_time' => $conference->end_time,      // Get end time from the conference
    ]);

    // Step 4: Redirect back to the conference page with success message
    return redirect()->route('conferences.show', $request->conference_id)
        ->with('success', 'Room added successfully!');
}
}
