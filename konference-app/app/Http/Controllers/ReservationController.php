<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Conference;
use App\Http\Controllers\ConferenceController;

class ReservationController extends Controller
{
    public function create()
    {
        $conferences = Conference::all(); // Get all conferences
        $conferenceController = new ConferenceController();

        foreach ($conferences as $conference) {
            if (!$conferenceController->checkCapacity($conference)) {
                
                // removing full conferences
                $conferences = $conferences->filter(function ($conf) use ($conference) {
                    return $conf->id !== $conference->id;
                });
            }
        }

        return view('reservations.CreateReservation', compact('conferences'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:20',
            'conference_ids' => 'required',
            'conference_ids.*' => 'exists:conferences,id',
        ]);
        
        // Create the reservation
        foreach ($validated['conference_ids'] as $conference_id) {
            Reservation::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'conference_id' => $conference_id,
                'is_paid' => false,
                'user_id' => Auth::id(),
            ]);
        }

        if (!Auth::check()) {
            $request->session()->put('guest_email', $validated['email']);
        }

        return redirect()->route('home')->with('success', 'Reservation created successfully!');
    }

    public function index(Request $request)
    {
        if (Auth::check()) {
            // Fetch reservations for the authenticated user
            $reservations = Auth::user()->reservations;
        } 
        else {
            // Fetch reservations for the unauthenticated user based on email stored in the session
            $userEmail = $request->session()->get('guest_email');
            if ($userEmail) {
                $reservations = Reservation::where('email', $userEmail)->get();
            }
            else {
                $reservations = collect(); // Empty collection
            }
        }
        return view('reservations.MyReservations', compact('reservations'));
    }

    public function manage($conference_id)
    {
        $conference = Conference::findOrFail($conference_id);
        $reservations = Reservation::where('conference_id', $conference_id)->get();
        if (Auth::user()->id !== $conference->user_id && Auth::user()->role !== 'admin') {
            return redirect()->route('conferences.show', $conference_id)
                ->with('error', 'You are not authorized to manage reservations.');
        }
        return view('reservations.manage', compact('conference', 'reservations'));
    }

    public function confirm($reservation_id)
    {
        $reservation = Reservation::findOrFail($reservation_id);
        $reservation->is_paid = true;
        $reservation->save();
        return redirect()->route('reservations.manage', $reservation->conference_id)
            ->with('success', 'Reservation confirmed successfully!');
    }
}
