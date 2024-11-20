<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Conference;

class AvailableTickets implements ValidationRule
{
    protected $conferenceId;

    public function __construct(int $conferenceId)
    {
        $this->conferenceId = $conferenceId;
    }
    
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $conference = Conference::with('reservations')->find($this->conferenceId);
        if (!$conference) {
            $fail('The selected conference does not exist.');
            return;
        }

        $availableTickets = $conference->capacity - $conference->reservations->count();
        if ($value > $availableTickets) {
            $fail("The number of tickets requested for '{$conference->name}' exceeds the available tickets ({$availableTickets}).");
        }
    }
}
