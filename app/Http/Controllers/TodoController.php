<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    /**
     * Display a listing of todos for the authenticated user.
     */
    public function index()
    {
        $userId = Auth::id();

        $todos = Todo::where('user_id', $userId)
            ->orderBy('due_date')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $stats = [
            'total' => Todo::where('user_id', $userId)->count(),
            'completed' => Todo::where('user_id', $userId)
                ->where('is_completed', true)
                ->count(),
            'pending' => Todo::where('user_id', $userId)
                ->where('is_completed', false)
                ->count(),
        ];

        return view('todos.index', compact('todos', 'stats'));
    }

    /**
     * Show the form for creating a new todo.
     */
    public function create()
    {
        return view('todos.create');
    }

    /**
     * Store a newly created todo.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date|after_or_equal:today',
        ]);

        $todo = new Todo();
        $todo->user_id = Auth::id();
        $todo->title = $request->title;
        $todo->description = $request->description;
        $todo->due_date = $request->due_date;
        $todo->save();

        return redirect()->route('todos.index')
            ->with('success', 'Todo created successfully!');
    }

    /**
     * Show the form for editing the specified todo.
     */
    public function edit($id)
    {
        $userId = Auth::id();
        $todo = Todo::where('user_id', $userId)->findOrFail($id);

        return view('todos.edit', compact('todo'));
    }

    /**
     * Update the specified todo.
     */
    public function update(Request $request, $id)
    {
        $userId = Auth::id();
        $todo = Todo::where('user_id', $userId)->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date|after_or_equal:today',
        ]);

        $todo->title = $request->title;
        $todo->description = $request->description;
        $todo->due_date = $request->due_date;
        $todo->save();

        return redirect()->route('todos.index')
            ->with('success', 'Todo updated successfully!');
    }

    /**
     * Remove the specified todo.
     */
    public function destroy($id)
    {
        $userId = Auth::id();
        $todo = Todo::where('user_id', $userId)->findOrFail($id);
        $todo->delete();

        return redirect()->route('todos.index')
            ->with('success', 'Todo deleted successfully!');
    }

    /**
     * Mark todo as completed.
     */
    public function complete($id)
    {
        $userId = Auth::id();
        $todo = Todo::where('user_id', $userId)->findOrFail($id);

        $todo->is_completed = true;
        $todo->save();

        return redirect()->route('todos.index')
            ->with('success', 'Todo marked as completed!');
    }

    /**
     * Mark todo as pending.
     */
    public function pending($id)
    {
        $userId = Auth::id();
        $todo = Todo::where('user_id', $userId)->findOrFail($id);

        $todo->is_completed = false;
        $todo->save();

        return redirect()->route('todos.index')
            ->with('success', 'Todo marked as pending!');
    }

    /**
     * Toggle todo status (complete/pending).
     */
    public function toggleStatus($id)
    {
        $userId = Auth::id();
        $todo = Todo::where('user_id', $userId)->findOrFail($id);

        $todo->is_completed = !$todo->is_completed;
        $todo->save();

        $status = $todo->is_completed ? 'completed' : 'pending';
        return redirect()->route('todos.index')
            ->with('success', "Todo marked as $status!");
    }
}