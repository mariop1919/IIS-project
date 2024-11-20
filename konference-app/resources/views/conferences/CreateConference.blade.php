<!-- resources/views/conferences/create.blade.php -->

@extends('layouts.layout')

@section('title', 'Create Conference')

@section('content')
<div class="container">
    <h1>Create a New Conference</h1>

    <form action="{{ route('conferences.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}">
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    
        <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" class="form-control" value="{{ old('location') }}">
            @error('location')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    
        <div class="form-group">
            <label for="capacity">Capacity:</label>
            <input type="number" id="capacity" name="capacity" class="form-control" value="{{ old('capacity') }}">
            @error('capacity')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" step="0.01" id="price" name="price" class="form-control" value="{{ old('price') }}">
            @error('price')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="start_time">Start Time:</label>
            <input type="datetime-local" id="start_time" name="start_time" class="form-control" value="{{ old('start_time') }}">
            @error('start_time')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    
        <div class="form-group">
            <label for="end_time">End Time:</label>
            <input type="datetime-local" id="end_time" name="end_time" class="form-control" value="{{ old('end_time') }}">
            @error('end_time')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    
        <button type="submit" class="btn btn-primary">Create Conference</button>
    </form>
</div>
@endsection