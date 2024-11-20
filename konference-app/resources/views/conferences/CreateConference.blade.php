<!-- resources/views/conferences/create.blade.php -->

@extends('layouts.layout')

@section('title', 'Create Conference')

@section('content')
<div class="container">
    <h1>Create a New Conference</h1>

    <form action="{{ route('conferences.store') }}" method="POST">
        @csrf
    
        <!-- Name -->
        <div class="form-group">
            <label for="name">Name <span class="text-danger">*</span></label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>
    
        <!-- Location (Optional) -->
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" id="location" name="location" class="form-control" value="{{ old('location') }}">
        </div>
    
        <!-- Capacity -->
        <div class="form-group">
            <label for="capacity">Capacity <span class="text-danger">*</span></label>
            <input type="number" id="capacity" name="capacity" class="form-control" value="{{ old('capacity') }}" required>
        </div>
    
        <!-- Price -->
        <div class="form-group">
            <label for="price">Price <span class="text-danger">*</span></label>
            <input type="number" id="price" name="price" class="form-control" value="{{ old('price') }}" required>
        </div>
    
        <!-- Start Time -->
        <div class="form-group">
            <label for="start_time">Start Time <span class="text-danger">*</span></label>
            <input type="datetime-local" id="start_time" name="start_time" class="form-control" value="{{ old('start_time') }}" required>
        </div>
    
        <!-- End Time -->
        <div class="form-group">
            <label for="end_time">End Time <span class="text-danger">*</span></label>
            <input type="datetime-local" id="end_time" name="end_time" class="form-control" value="{{ old('end_time') }}" required>
        </div>
    
        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Create Conference</button>
    </form>
    
</div>
@endsection