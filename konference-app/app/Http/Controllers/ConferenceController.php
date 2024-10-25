<?php

namespace App\Http\Controllers;


use App\Models\Conference;
use Illuminate\Http\Request;

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
        return view('conferences.show', compact('conference'));
    }
    public function create()
    {
        return view('conferences.create');
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
            'user_id' => auth()->id(), // id user
        ]);

        return redirect()->route('home')->with('success', 'Conference created successfully!');
    }

}
