<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): RedirectResponse
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        return redirect()->route('users.show', $request->user());
    }

    public function create(): View
    {
        return view('users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create($validated);
        Auth::login($user);

        return redirect()->route('tasks.index')
            ->with('success', 'Account created successfully!');
    }

    public function show(User $user): View
    {
        $this->authorizeUserOwner($user);

        return view('users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        $this->authorizeUserOwner($user);

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $this->authorizeUserOwner($user);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if (blank($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.show', $user)
            ->with('success', 'User updated successfully!');
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->authorizeUserOwner($user);

        $user->delete();
        Auth::logout();

        return redirect()->route('login')
            ->with('success', 'Account deleted successfully!');
    }

    private function authorizeUserOwner(User $user): void
    {
        abort_unless(auth()->id() === $user->id, 404);
    }
}
