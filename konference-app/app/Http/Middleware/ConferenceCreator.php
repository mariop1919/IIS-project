<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Conference; // Make sure to import the Conference model
class ConferenceCreator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure  $next
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Get the conference ID from the route (make sure to pass conference ID from the route)
        $conferenceId = $request->route('conference');
        
        // Explicitly retrieve the conference object from the database
        $conference = Conference::find($conferenceId);
        
        // Check if the conference exists and the user is an admin or the creator of the conference
        if ($conference && Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->id === $conference->user_id)) {
            
            return $next($request); // Allow the user to continue
        }

        // Redirect with an error if not authorized
        return redirect()->route('home')->with('error', 'You do not have permission to access this conference.');
    }
}