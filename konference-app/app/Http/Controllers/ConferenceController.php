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
        
        $pivotData = DB::table('conference_room')
            ->where('conference_id', $id)
            ->select('start_time', 'end_time')
            ->first();

        $startTime = $pivotData ? $pivotData->start_time : null;
        $endTime = $pivotData ? $pivotData->end_time : null;

        return view('conferences.detail', compact('conference', 'startTime', 'endTime'));
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
            'location' => 'required|alpha|max:255',
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ], [
            // Custom error message for location field
            'location.alpha' => 'The location field may only contain letters.',
            'location.max' => 'The location may not be greater than 255 characters.',
        ]);

        // create new conference
        Conference::create([
            'name' => $validated['name'],
            'location' => $validated['location'],
            'capacity' => $validated['capacity'],
            'price' => $validated['price'],
            'user_id' => Auth::id(), // Get the currently authenticated user's ID
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
        $conference->delete();

        return redirect()->route('conferences.index')
            ->with('success', 'Conference deleted successfully!');
    }
}
