@extends('layouts.layout')

@section('title', 'Manage Users')

@section('content')
<div class="container">
    <h1>Manage Users</h1>
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('admin.add') }}" class="btn btn-primary">Add User</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->is_activated ? 'Active' : 'Inactive' }}</td>
                    <td>
                        <a href="{{ route('admin.edit', $user) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('admin.destroy', $user) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                        @if($user->is_activated)
                            <form action="{{ route('admin.deactivate', $user) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-secondary" onclick="return confirm('Are you sure?')">Deactivate</button>
                            </form>
                        @else
                            <form action="{{ route('admin.activate', $user) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure?')">Activate</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection