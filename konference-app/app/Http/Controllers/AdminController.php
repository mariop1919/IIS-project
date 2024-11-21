<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 'admin')->get();
        return view('admin.index', compact('users'));
    }

    public function add()
    {
        return view('admin.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:admin,organizer,speaker,guest',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_activated' => 1,
        ]);

        return redirect()->route('admin.index')->with('success', 'User added successfully.');
    }

    public function edit(User $user)
    {
        return view('admin.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($request->all());

        return redirect()->route('admin.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.index')->with('success', 'User deleted successfully.');
    }

    public function deactivate(User $user)
    {
        $user->update(['is_activated' => false]);
        return redirect()->route('admin.index')->with('success', 'User deactivated successfully.');
    }

    public function activate(User $user)
    {
        $user->update(['is_activated' => true]);
        return redirect()->route('admin.index')->with('success', 'User activated successfully.');
    }
}
