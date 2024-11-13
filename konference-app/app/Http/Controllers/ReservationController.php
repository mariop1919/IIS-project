<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Conference;

class ReservationController extends Controller
{
    public function create()
    {
        $conferences = Conference::all(); // Get all conferences
        return view('reservations.CreateReservation', compact('conferences'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:20',
            'conference_id' => 'required|exists:conferences,id',
        ]);
        
        // Create the reservation
        Reservation::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'conference_id' => $validated['conference_id'],
            'is_paid' => false,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('home')->with('success', 'Reservation created successfully!');
    }
}
