<?php

namespace App\Http\Controllers;


use App\Models\Conference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConferenceController extends Controller
{
    public function index()
    {
        $conferences = Conference::all(); // Get all conferences from the database
        return view('conferences.index', compact('conferences')); // Pass data to the view
    }
    
    public function show($id)
    {
        $conference = Conference::with(['presentations.user', 'presentations.room'])->findOrFail($id);
        return view('conferences.detail', compact('conference'));
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
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
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
