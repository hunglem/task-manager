<?php

namespace App\Http\Controllers;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TaskController extends Controller
{

    public function index(Request $request): View
    {

        $search = trim($request->input('search', ''));
        $sortBy = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');

        $allowedSorts = ['created_at', 'title', 'priority', 'is_completed'];

        if (! in_array($sortBy, $allowedSorts, true)) {
            $sortBy = 'created_at';
        }

        if (! in_array($sortDirection, ['asc', 'desc'], true)) {
            $sortDirection = 'desc';
        }

        $user = $request->user();

        $tasks = Task::query()
            ->with('user')
            ->when(! $user->is_super_user, function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->when($sortBy === 'priority', function ($query) use ($sortDirection) {
                $query->orderByRaw(
                    "CASE priority WHEN 'high' THEN 3 WHEN 'medium' THEN 2 WHEN 'low' THEN 1 END {$sortDirection}"
                );
            }, function ($query) use ($sortBy, $sortDirection) {
                $query->orderBy($sortBy, $sortDirection);
            })
            ->paginate(6)
            ->appends($request->query());

        return view('tasks.index', [
            'tasks' => $tasks,
            'search' => $search,
            'sortBy' => $sortBy,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function create(): View
    {
        return view('tasks.create', [
            'users' => $this->assignableUsers(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority'    => 'required|in:low,medium,high',
            'user_id'     => [
                Rule::requiredIf($request->user()->is_super_user),
                'nullable',
                'exists:users,id',
            ],
        ]);

        $validated['user_id'] = $request->user()->is_super_user
            ? $validated['user_id']
            : $request->user()->id;

        Task::create($validated);

        return redirect()->route('tasks.index')
            ->with('success', 'Task created successfully!');
    }

    public function show(Task $task): View
    {
        $this->authorizeTaskAccess($task);

        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task): View
    {
        $this->authorizeTaskAccess($task);

        return view('tasks.edit', [
            'task' => $task,
            'users' => $this->assignableUsers(),
        ]);
    }

    public function update(Request $request, Task $task): RedirectResponse
    {
        $this->authorizeTaskAccess($task);

        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'priority'     => 'required|in:low,medium,high',
            'is_completed' => 'sometimes|boolean',
            'user_id'      => 'nullable|exists:users,id',
        ]);

        $validated['is_completed'] = $request->has('is_completed');
        $validated['user_id'] = $request->user()->is_super_user
            ? ($validated['user_id'] ?? $task->user_id)
            : $request->user()->id;

        $task->update($validated);

        return redirect()->route('tasks.index')
            ->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $this->authorizeTaskAccess($task);

        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully!');
    }

    private function authorizeTaskAccess(Task $task): void
    {
        abort_unless(auth()->user()->is_super_user || auth()->id() === $task->user_id, 404);
    }

    private function assignableUsers()
    {
        if (! auth()->user()->is_super_user) {
            return collect();
        }

        return User::orderBy('name')->get();
    }
}
