@extends('layouts.layout')

@section('title', 'Create Reservation')

@section('content')

<div class="container">
    <h2>Create Reservation</h2>
    <form action="{{ route('reservations.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>

        <!-- Conference Selection -->
        <div class="form-group">
            <label for="conference_select">Conference</label>
            <select class="form-control" id="conference_select">
                <option disabled selected>Select a Conference</option>
                @foreach($conferences as $conference)
                    <option value="{{ $conference->id }}">{{ $conference->name }}</option>
                @endforeach
            </select>
            <button type="button" id="add_conference" class="btn btn-secondary mt-2">Add Conference</button>
        </div>

        <!-- List of Selected Conferences -->
        <h4>Selected Conferences</h4>
        <ul id="selected_conferences"></ul>

        <!-- Hidden Fields for Selected Conferences -->
        <div id="hidden_conference_inputs"></div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<!-- JavaScript to handle adding and removing conferences -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
    const conferenceSelect = document.getElementById("conference_select");
    const addConferenceButton = document.getElementById("add_conference");
    const selectedConferencesList = document.getElementById("selected_conferences");
    const hiddenConferenceInputs = document.getElementById("hidden_conference_inputs");

    let selectedConferences = [];

    // Add conference to the selected list and remove from dropdown
    addConferenceButton.addEventListener("click", function() {
    const selectedOption = conferenceSelect.options[conferenceSelect.selectedIndex];
    const conferenceId = selectedOption.value;
    const conferenceName = selectedOption.text;

    // Check if the selected option is the default one
    if (selectedOption.disabled || !conferenceId) {
        alert("Please select a valid conference!");
        return;
    }

    // Check if the conference is already selected
    if (selectedConferences.some(conf => conf.id === conferenceId)) {
        alert("Conference already added!");
        return;
    }

    // Add to selected conferences array
    selectedConferences.push({ id: conferenceId, name: conferenceName });
    updateSelectedConferences();

    // Remove selected conference from dropdown
    conferenceSelect.remove(conferenceSelect.selectedIndex);
});


    // Update the displayed list of selected conferences
    function updateSelectedConferences() {
        selectedConferencesList.innerHTML = "";
        hiddenConferenceInputs.innerHTML = "";

        selectedConferences.forEach(conf => {
            // Add to the displayed list
            const li = document.createElement("li");
            li.textContent = conf.name;

            const removeButton = document.createElement("button");
            removeButton.type = "button";
            removeButton.classList.add("btn", "btn-link", "text-danger");
            removeButton.textContent = "Remove";
            removeButton.addEventListener("click", function() {
                removeConference(conf.id);
            });

            li.appendChild(removeButton);
            selectedConferencesList.appendChild(li);

            // Add hidden input field for the conference
            const hiddenInput = document.createElement("input");
            hiddenInput.type = "hidden";
            hiddenInput.name = "conference_ids[]";
            hiddenInput.value = conf.id;
            hiddenConferenceInputs.appendChild(hiddenInput);
        });
    }

    // Remove conference from selected list and re-add to dropdown
    function removeConference(conferenceId) {
        const conference = selectedConferences.find(conf => conf.id === conferenceId);

        // Remove from selected conferences array
        selectedConferences = selectedConferences.filter(conf => conf.id !== conferenceId);
        updateSelectedConferences();

        // Re-add removed conference to dropdown
        const option = document.createElement("option");
        option.value = conference.id;
        option.text = conference.name;
        conferenceSelect.add(option);
    }
});
</script>

@endsection
