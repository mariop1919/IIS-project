<!-- resources/views/conferences/create.blade.php -->

@extends('layouts.layout')

@section('title', 'Create Conference')

@section('content')
<div class="container">
    <h1>Create a New Conference</h1>

    <form action="{{ route('conferences.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Conference Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter conference name" required>
        </div>
        
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" name="location" class="form-control" placeholder="Enter location" required>
        </div>
        
        <div class="form-group">
            <label for="capacity">Capacity</label>
            <input type="number" name="capacity" class="form-control" placeholder="Enter capacity" required>
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" name="price" class="form-control" placeholder="Enter price" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Conference</button>
    </form>
</div>
@endsection