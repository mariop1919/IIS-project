<?php
namespace App\Http\Controllers;

use App\Models\Presentation;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function vote($presentationId)
    {
        $user = Auth::user();
        $presentation = Presentation::findOrFail($presentationId);

        // Check if the user has already voted for this presentation
        if ($user->votedPresentations->contains($presentation->id)) {
            return redirect()->back()->with('error', 'You have already voted for this presentation.');
        }

        // Add vote
        $user->votedPresentations()->attach($presentation->id);

        return redirect()->back()->with('success', 'Your vote has been recorded!');
    }

    public function unvote($presentationId)
    {
        $user = Auth::user();
        $user->votedPresentations()->detach($presentationId);
        
        return redirect()->back()->with('success', 'You have removed your vote for this presentation.');
    }
}