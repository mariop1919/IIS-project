@extends('layouts.layout')

@section('title', 'My Reservations')

@section('content')
<div class="container">
    <h2 class="text-center mb-5">My Reservations</h2>

    @if($reservations->isEmpty())
        <p class="text-center">You have no reservations.</p>
    @else
        <div class="ticket-container">
            @foreach($reservations as $reservation)
                <div class="ticket-box" id="ticket-{{ $reservation->id }}">
                    <div class="ticket-header">
                        <div>
                            <h4>{{ $reservation->conference->name }}</h4>
                        </div>
                        <span class="badge bg-info">
                            {{ \Carbon\Carbon::parse($reservation->conference->start_time)->format('g:i A') }} 
                            <span class="text-muted">to</span>
                            {{ \Carbon\Carbon::parse($reservation->conference->end_time)->format('g:i A') }}
                        </span>
                    </div>

                    <div class="ticket-body">
                        <p><strong>Name:</strong> {{ $reservation->name }}</p>
                        <p><strong>Email:</strong> {{ $reservation->email }}</p>
                        <p><strong>Paid:</strong> {{ $reservation->is_paid ? 'Yes' : 'No' }}</p>

                        <!-- Hidden details initially -->
                        <div class="ticket-details d-none">
                            <p><strong>Phone:</strong> {{ $reservation->phone }}</p>
                            <p><strong>Location:</strong> {{ $reservation->conference->location }}</p>
                        </div>
                    </div>

                    <div class="ticket-footer">
                        <!-- Toggle details button -->
                        <button class="btn btn-info btn-sm toggle-details">View Details</button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Add the CSS inside the <style> tag -->
<style>
    .ticket-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
    }

    .ticket-box {
        border: 2px solid #007bff;
        padding: 20px;
        border-radius: 10px;
        background-color: #f7f9fc;
        width: 100%;
        max-width: 400px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease-in-out;
    }

    .ticket-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .ticket-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .ticket-header h4 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: bold;
    }

    .ticket-body p {
        margin: 10px 0;
        font-size: 0.95rem;
    }

    .ticket-footer {
        margin-top: 15px;
        text-align: right;
    }

    .ticket-footer .btn {
        padding: 5px 10px;
    }

    .ticket-body p strong {
        color: #007bff;
    }

    .ticket-box .badge {
        font-size: 0.9rem;
        padding: 5px 10px;
    }

    .ticket-details {
        margin-top: 10px;
    }

    /* Styles for expanding the ticket box */
    .ticket-box.expanded {
        max-height: 600px; /* Adjust if necessary */
        overflow: hidden;
    }
</style>

<!-- Add the JS at the end of the content or in a script section -->
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleButtons = document.querySelectorAll('.toggle-details');

        toggleButtons.forEach(button => {
            button.addEventListener('click', function () {
                const ticketBox = this.closest('.ticket-box');
                const details = ticketBox.querySelector('.ticket-details');

                // Toggle visibility of details
                details.classList.toggle('d-none');
                ticketBox.classList.toggle('expanded');

                // Change button text based on visibility
                if (details.classList.contains('d-none')) {
                    this.textContent = 'View Details';
                } else {
                    this.textContent = 'Hide Details';
                }
            });
        });
    });
</script>
@endsection

@endsection