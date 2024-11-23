@extends('layouts.layout')

@section('title', 'Edit User')

@section('content')
<div class="container">
    <h1>Edit User</h1>
    <form action="{{ route('admin.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="name">Name <span class="text-danger">*</span></label> 
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email <span class="text-danger">*</span></label> 
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>
@endsection
