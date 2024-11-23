<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Conference;
use App\Http\Controllers\ConferenceController;
use App\Rules\AvailableTickets;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    public function create()
    {
        $conferences = Conference::with('reservations')->get(); // Get all conferences with reservations
        $conferenceController = new ConferenceController();

        $availableTickets = [];

        foreach ($conferences as $conference) {
            if (!$conferenceController->checkCapacity($conference)) {
                // removing full conferences
                $conferences = $conferences->filter(function ($conf) use ($conference) {
                    return $conf->id !== $conference->id;
                });
            }
            $availableTickets[$conference->id] = $conference->capacity - $conference->reservations->count();
        }

        return view('reservations.CreateReservation', compact('conferences', 'availableTickets'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'nullable|string|max:20',
            'conference_ids' => 'required|array',
            'conference_ids.*' => 'exists:conferences,id',
            'num_of_reservations' => 'required|array',
            'num_of_reservations.*' => ['required', 'integer', 'min:1', 
            function ($attribute, $value, $fail) use ($request) {
                // Extract the index of the current reservation from the attribute name
                preg_match('/num_of_reservations\.(\d+)/', $attribute, $matches);
                $conference_id = $matches[1];
                $rule = new AvailableTickets($conference_id);
                $rule->validate($attribute, $value, $fail);
            }],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)  // Use default error bag
                ->withInput();
        }

        $validated = $validator->validated();

        // Create the reservations
        foreach ($validated['conference_ids'] as $conference_id) {
            $numOfReservations = $validated['num_of_reservations'][$conference_id];
            for ($i = 0; $i < $numOfReservations; $i++) {
                Reservation::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'],
                    'conference_id' => $conference_id,
                    'is_paid' => false,
                    'user_id' => Auth::id(),
                ]);
            }
        }

        if (!Auth::check()) { // Store the email in the session if the user is not authenticated
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

    public function confirm($conference_id, $reservation_id)
    {
        $reservation = Reservation::findOrFail($reservation_id);
        $reservation->is_paid = true;
        $reservation->save();

        return redirect()->route('reservations.manage', $conference_id)
            ->with('success', 'Reservation confirmed successfully!');
    }

    public function cancel($reservation_id)
    {
        $reservation = Reservation::findOrFail($reservation_id);
        if (!$reservation->is_paid) {
            $reservation->delete();
            return redirect()->route('reservations.manage', $reservation->conference_id)
                ->with('success', 'Reservation canceled successfully!');
        }
    }
}
