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

}
