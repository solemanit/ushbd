<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        $currentUser = auth('admin')->user();

        if ($currentUser->role === 'admin') {
            $admins = Admin::all();
        } else {
            $admins = Admin::where('role', '!=', 'admin')->get();
        }

        return view('admin.auth.profile.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.auth.profile.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|confirmed|min:8',
            'role' => 'required|in:admin,manager,editor',
        ]);

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            // 'status' এখানে না দিলেও চলবে, মাইগ্রেশনে default(true)
        ]);

        return redirect()->route('admin.profile.index')->with('success', 'Admin created successfully.');
    }

    public function edit(Admin $admin)
    {
        return view('admin.auth.profile.edit', compact('admin'));
    }

    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('admins')->ignore($admin->id),
            ],
            'role' => ['required', Rule::in(['admin', 'manager', 'editor'])],
            'password' => 'nullable|confirmed|min:8',
            'status' => ['nullable', Rule::in([0, 1])],
        ]);

        // non-admin ইউজাররা role পরিবর্তন করতে পারবে না
        if (auth('admin')->user()->role !== 'admin') {
            unset($request['role']);
        }

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role ?? $admin->role,
            'password' => $request->filled('password') ? Hash::make($request->password) : $admin->password,
            'status' => $request->has('status') ? $request->status : 0,
        ]);

        return redirect()->route('admin.profile.index')->with('success', 'Admin updated successfully.');
    }

    public function destroy(Admin $admin)
    {
        $currentUser = auth('admin')->user();

        if ($currentUser->role !== 'admin' && $admin->role === 'admin') {
            abort(403, 'You are not authorized to delete an admin user.');
        }

        $admin->delete();

        return redirect()->route('admin.profile.index')->with('success', 'User deleted successfully.');
    }
}
