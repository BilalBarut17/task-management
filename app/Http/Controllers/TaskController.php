<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tasks = auth()->user()->tasks()->latest()->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable'
        ]);

        auth()->user()->tasks()->create($request->all());

        return redirect()->route('tasks.index')->with('success', 'Görev başarıyla oluşturuldu.');
    }

    public function edit(Task $task)
    {
        $this->authorize('update', $task);
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);
        
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable'
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Görev başarıyla güncellendi.');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Görev başarıyla silindi.');
    }

    public function toggleComplete(Task $task)
    {
        $this->authorize('update', $task);
        $task->update([
            'status' => $task->status === 'pending' ? 'completed' : 'pending'
        ]);
        return redirect()->route('tasks.index');
    }
} 