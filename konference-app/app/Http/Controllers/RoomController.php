<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\Room;
use App\Models\ConferenceRoom;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    // Zobrazí formulář pro přidání místnosti ke konkrétní konferenci
    public function create(Conference $conference)
    {
        // Získá všechny místnosti, které lze přidat ke konferenci
        $rooms = Room::all();
        return view('rooms.create', compact('conference', 'rooms'));
    }

    // Uloží novou místnost přidruženou ke konferenci
    public function store(Request $request, Conference $conference)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        // Kontrola časových kolizí v místnosti
        $hasCollision = ConferenceRoom::where('room_id', $validated['room_id'])
            ->where('conference_id', $conference->id)
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                      ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']]);
            })
            ->exists();

        if ($hasCollision) {
            return redirect()->back()->withErrors(['error' => 'Selected time conflicts with another booking in this room.']);
        }

        // Uložíme místnost do konference
        ConferenceRoom::create([
            'conference_id' => $conference->id, // Explicitly set the conference_id
            'room_id' => $validated['room_id'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
        ]);
    

        return redirect()->route('conferences.show', $conference)->with('success', 'Room added successfully!');
    }
}
