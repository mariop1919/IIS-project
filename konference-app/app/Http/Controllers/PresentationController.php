<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\Presentation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Question;
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
            'photo' => 'nullable|url',
        ]);

        // Create the presentation with status 'pending'
        Presentation::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'photo' => $validated['photo'],
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
        public function approve(Request $request, $conference_id, $presentationId)
    {
        $presentation = Presentation::findOrFail($presentationId);
        $conference = $presentation->conference;
        

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
        $startTime = Carbon::parse($validated['start_time']);
        $endTime = Carbon::parse($validated['end_time']);
        $conferenceStartTime = Carbon::parse($conference->start_time);
        $conferenceEndTime = Carbon::parse($conference->end_time);
        $conferenceTimeCheck = $startTime < $conference->start_time || $endTime > $conference->end_time;
        //dd($startTime, $conferenceStartTime, $endTime, $conferenceEndTime, $conferenceTimeCheck);
        // If there's a conflict in presentation time or the time is outside the conference range, show error
        if ($conferenceTimeCheck) {
            return redirect()->back()->with('error', 'Presentation time must be within the conference schedule.');
        }

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
    public function edit($conference_id,$id)
    {
        $presentation = Presentation::findOrFail($id);
        $conference = $presentation->conference; // Fetch the associated conference
        $rooms = $conference->rooms; // Fetch all rooms for the conference
        $photo = $presentation->photo;

        return view('presentations.edit', compact('presentation', 'conference', 'rooms'));
    }

public function update(Request $request,$conference_id, $id)
{
    $presentation = Presentation::findOrFail($id);
    $conference = $presentation->conference;

        // Validate the request
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'photo' => 'nullable|url',
        ]);

    // Update the presentation
    
    $roomId = $validated['room_id'];
    $startTime = $validated['start_time'];
    $endTime = $validated['end_time'];
    $photo = $validated['photo'] ?? $presentation->photo;
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
    $startTime = Carbon::parse($validated['start_time']);
    $endTime = Carbon::parse($validated['end_time']);
    $conferenceStartTime = Carbon::parse($conference->start_time);
    $conferenceEndTime = Carbon::parse($conference->end_time);
    $conferenceTimeCheck = $startTime < $conference->start_time || $endTime > $conference->end_time;
    
    $conferenceTimeCheck = $startTime < $conference->start_time || $endTime > $conference->end_time;

    // If there's a conflict in presentation time or the time is outside the conference range, show error
    if ($conferenceTimeCheck) {
        //dd($conferenceTimeCheck);
        return redirect()->back()->with('error', 'Presentation time must be within the conference schedule.');
    }
    if ($presentationConflicts ) {
        return redirect()->back()->with('error', 'The selected room is already booked during this time.');
    }
    $presentation->update([
        'room_id' => $validated['room_id'],
        'start_time' => $validated['start_time'],
        'end_time' => $validated['end_time'],
        'photo' => $photo,
    ]);
    return redirect()->route('presentations.manage', $presentation->conference_id)
        ->with('success', 'Presentation updated successfully!');
}
    public function timetable(Request $request)
    {
        $date = $request->get('date', now()->startOfWeek());
        $startOfWeek = Carbon::parse($date)->startOfWeek();
        $endOfWeek = $startOfWeek->copy()->endOfWeek();

        $presentations = Presentation::where('status', 'approved')
            ->where('user_id', Auth::id())
            ->whereBetween('start_time', [$startOfWeek, $endOfWeek])
            ->with(['room', 'user'])
            ->get()
            ->groupBy(function ($presentation) {
                return Carbon::parse($presentation->start_time)->format('l'); // Group by day name
            });

        return view('presentations.timetable', [
            'presentations' => $presentations,
            'startOfWeek' => $startOfWeek,
            'endOfWeek' => $endOfWeek,
            'formattedStartOfWeek' => $startOfWeek->format('F j, Y'),
            'formattedEndOfWeek' => $endOfWeek->format('F j, Y'),
            ]);
    }
        public function destroy($conference_id,$id)
    {
        $presentation = Presentation::findOrFail($id);
        $presentation->delete();

        return redirect()->back()->with('success', 'Presentation rejected successfully.');
    }

    public function attendeeSchedule(Request $request)
    {
        $user = Auth::user();
        $date = $request->input('date', now()->toDateString());
        $startOfWeek = Carbon::parse($date)->startOfWeek();
        $endOfWeek = $startOfWeek->copy()->endOfWeek();
        $formattedStartOfWeek = $startOfWeek->format('F j, Y');
        $formattedEndOfWeek = $endOfWeek->format('F j, Y');

    $conferenceIds = DB::table('reservations')
        ->where('user_id', $user->id)
        ->pluck('conference_id');

        // Fetch presentations for those conferences within the specified week
        $presentations = Presentation::whereIn('conference_id', $conferenceIds)
            ->whereBetween('start_time', [$startOfWeek, $endOfWeek])
            ->with(['room', 'user'])
            ->orderBy('start_time')
            ->get()
            ->groupBy(function ($presentation) {
                return Carbon::parse($presentation->start_time)->format('l');
            });

        return view('presentations.attendeeSchedule', compact('presentations', 'startOfWeek', 'endOfWeek', 'formattedStartOfWeek', 'formattedEndOfWeek', 'user'));
    }

public function addToPersonalSchedule(Request $request, $presentationId)
{
    $userId = Auth::id();

    if (DB::table('user_presentation')->where('user_id', $userId)->where('presentation_id', $presentationId)->exists()) {
        return redirect()->back()->with('error', 'Presentation is already in your personal schedule.');
    }

    DB::table('user_presentation')->insert([
        'user_id' => $userId,
        'presentation_id' => $presentationId,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

        return redirect()->back()->with('success', 'Presentation added to your personal schedule.');
    }

public function removeFromPersonalSchedule(Request $request, Presentation $presentation)
{
    $userId = Auth::id();
    DB::table('user_presentation')->where('user_id', $userId)->where('presentation_id', $presentation->id)->delete();

        return redirect()->route('presentations.personalSchedule')->with('success', 'Presentation removed from your personal schedule.');
    }

public function personalSchedule(Request $request)
{
    $user = Auth::user();
    $userId = $user->id;
    $date = $request->input('date', now()->toDateString());
    $startOfWeek = Carbon::parse($date)->startOfWeek();
    $endOfWeek = $startOfWeek->copy()->endOfWeek();
    $formattedStartOfWeek = $startOfWeek->format('F j, Y');
    $formattedEndOfWeek = $endOfWeek->format('F j, Y');

    $presentationIds = DB::table('user_presentation')->where('user_id', $userId)->pluck('presentation_id');

    $presentations = Presentation::whereIn('id', $presentationIds)
        ->whereBetween('start_time', [$startOfWeek, $endOfWeek])
        ->with(['room', 'user'])
        ->orderBy('start_time')
        ->get()
        ->groupBy(function ($presentation) {
            return Carbon::parse($presentation->start_time)->format('l');
        });

        return view('presentations.personalSchedule', compact('presentations', 'startOfWeek', 'endOfWeek', 'formattedStartOfWeek', 'formattedEndOfWeek', 'user'));
    }

    public function addQuestion(Request $request, $presentationId)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
        ]);

        $question = new Question();
        $question->presentation_id = $presentationId;
        $question->question = $validated['question']; // Save the question text
        $question->save();

        return redirect()->back()->with('success', 'Question added successfully.');
    }

    public function showLeaderboard(Request $request)
    {
        // Get all conferences for the dropdown
        $conferences = Conference::all();

        // Check if a specific conference was selected
        $selectedConferenceId = $request->input('conference_id');
        $presentations = [];

        if ($selectedConferenceId) {
            // Retrieve presentations for the selected conference, ordered by votes
            $presentations = Presentation::where('conference_id', $selectedConferenceId)
                ->where('status', 'approved')
                ->withCount('votedUsers') // Assuming votedUsers relation is set up
                ->orderByDesc('voted_users_count')
                ->get();
        }

        return view('presentations.leaderboard', compact('conferences', 'presentations', 'selectedConferenceId'));
    }
}
