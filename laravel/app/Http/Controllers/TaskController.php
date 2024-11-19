<?php

namespace App\Http\Controllers;

use App\Models\Environment;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
    
        $environments = Auth::user()->environments->with('tasks')->get();
        dd($environments);
    
        return view('tasks.index', compact('environments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'environment_id' => 'required|exists:environments,id',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id', 
        ]);
    
        $task = Task::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'status' => 'pending',
            'environment_id' => $validated['environment_id'],
        ]);
    
        foreach ($validated['user_ids'] as $userId) {
            $task->users()->attach($userId, ['role' => 'executor']);
        }
    
        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        $environment = $task->environment;
        abort_unless(
            $environment->users->contains(Auth::id()) || $task->users->contains(Auth::id()),
            403
        );

        return view('tasks.show', compact('task'));
    }

    public function addUsersToTask(Request $request, Task $task)
    {
        $validated = $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        foreach ($validated['user_ids'] as $userId) {
            $task->users()->attach($userId, ['role' => 'executor']);
        }

        return redirect()->route('tasks.show', $task)->with('success', 'Users added to task successfully.');
    }

    public function create()
    {
        $users = User::all();
        $environments = Environment::all();
        return view('tasks.create', compact('users', 'environments'));
    }
}
