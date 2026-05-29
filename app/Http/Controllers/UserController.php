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
    public function index(Request $request): View
    {
        $this->authorizeSuperUser();

        $search = $request->string('search')->toString();

        $users = User::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('is_super_user')
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('users.index', compact('users', 'search'));
    }

    public function create(Request $request): View
    {
        if ($request->user()) {
            $this->authorizeSuperUser();
        }

        return view('users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        if ($request->user() && ! $request->user()->is_super_user) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'is_super_user' => 'sometimes|boolean',
        ]);

        $validated['is_super_user'] = $request->user()?->is_super_user
            ? $request->boolean('is_super_user')
            : false;

        $user = User::create($validated);

        if ($request->user()?->is_super_user) {
            return redirect()->route('users.index')
                ->with('success', "{$user->name} was added successfully!");
        }

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
            'is_super_user' => 'sometimes|boolean',
        ]);

        if (blank($validated['password'])) {
            unset($validated['password']);
        }

        $validated['is_super_user'] = $request->user()?->is_super_user
            ? $request->boolean('is_super_user')
            : $user->is_super_user;

        $user->update($validated);

        return redirect()->route('users.show', $user)
            ->with('success', 'User updated successfully!');
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->authorizeUserOwner($user);

        $deletedOwnAccount = auth()->id() === $user->id;
        $user->delete();

        if ($deletedOwnAccount) {
            Auth::logout();

            return redirect()->route('login')
                ->with('success', 'Account deleted successfully!');
        }

        return redirect()->route('users.index')
            ->with('success', "{$user->name} was deleted successfully!");
    }

    private function authorizeUserOwner(User $user): void
    {
        abort_unless(auth()->user()?->is_super_user || auth()->id() === $user->id, 404);
    }

    private function authorizeSuperUser(): void
    {
        abort_unless(auth()->user()?->is_super_user, 404);
    }
}
