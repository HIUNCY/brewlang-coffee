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
        $users = User::orderBy('role')->orderBy('name')->get();
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
        if ($user->isOwner()) {
            return redirect()->back()->with('error', 'Owner account cannot be deactivated.');
        }

        $user->update(['is_active' => !$user->is_active]);

        return redirect()->back()->with('success', 'Staff account status updated.');
    }
}
