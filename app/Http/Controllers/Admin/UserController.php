<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::with('role')->orderByDesc('created_at')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        $roles = Role::orderBy('label')->get();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', Password::defaults(), 'confirmed'],
            'role_id'  => ['nullable', 'exists:roles,id'],
        ]);

        User::create([
            'name'              => $data['name'],
            'email'             => $data['email'],
            'password'          => Hash::make($data['password']),
            'is_admin'          => false,
            'email_verified_at' => now(),
            'role_id'           => $data['role_id'] ?? null,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', __('User created successfully.'));
    }

    public function edit(User $user): View
    {
        $roles = Role::orderBy('label')->get();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email,' . $user->id],
            'password' => ['nullable', Password::defaults(), 'confirmed'],
            'role_id'  => ['nullable', 'exists:roles,id'],
        ]);

        $user->update([
            'name'  => $data['name'],
            'email' => $data['email'],
        ]);

        if (! empty($data['password'])) {
            $user->update(['password' => Hash::make($data['password'])]);
        }

        // Don't override the super-admin's role assignment
        if (! $user->is_admin) {
            $user->update(['role_id' => $data['role_id'] ?? null]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', __('User updated successfully.'));
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->is_admin) {
            return redirect()->route('admin.users.index')
                ->with('error', __('Cannot delete the super admin user.'));
        }

        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', __('Cannot delete your own account.'));
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', __('User deleted successfully.'));
    }
}
