@extends('layouts.layout')

@section('title', 'Edit Conference')

@section('content')
    <div class="container">
        <h2>Edit Conference</h2>
        <form action="{{ route('conferences.update', $conference->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Name Field with Asterisk and Old Value -->
            <div class="form-group">
                <label for="name">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control" 
                       value="{{ old('name', $conference->name) }}" required>
            </div>

            <!-- Location Field with Old Value -->
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" name="location" id="location" class="form-control" 
                       value="{{ old('location', $conference->location) }}">
            </div>

            <!-- Capacity Field with Asterisk and Old Value -->
            <div class="form-group">
                <label for="capacity">Capacity <span class="text-danger">*</span></label>
                <input type="number" name="capacity" id="capacity" class="form-control" 
                       value="{{ old('capacity', $conference->capacity) }}" required>
            </div>

            <!-- Price Field with Old Value -->
            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" name="price" id="price" class="form-control" 
                       value="{{ old('price', $conference->price) }}">
            </div>

            <button type="submit" class="btn btn-primary">Update Conference</button>
        </form>
    </div>
@endsection
