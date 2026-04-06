<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreStaffRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class StaffAccountController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();
        return view('owner.staff.index', compact('users'));
    }

    public function create()
    {
        return view('owner.staff.create');
    }

    public function store(StoreStaffRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'staff';
        $data['is_active'] = true;

        User::create($data);

        return redirect()->route('owner.staff.index')->with('success', 'Staff account created successfully.');
    }

    public function toggleActive(User $user)
    {
        if ($user->role === 'owner') {
            return redirect()->back()->with('error', 'Cannot deactivate an owner account.');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        return redirect()->back()->with('success', "{$user->name}'s account is now " . ($user->is_active ? 'Active' : 'Inactive'));
    }
}
