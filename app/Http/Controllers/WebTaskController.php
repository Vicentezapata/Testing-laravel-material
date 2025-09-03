<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;

class WebTaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('project')->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $projects = Project::all();
        return view('tasks.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'project_id' => 'required|exists:projects,id',
        ]);
        Task::create($validated);
        return redirect()->route('tasks.index')->with('success', 'Tarea creada correctamente.');
    }

    public function edit(Task $task)
    {
        $projects = Project::all();
        return view('tasks.edit', compact('task', 'projects'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'project_id' => 'required|exists:projects,id',
        ]);
        $task->update($validated);
        return redirect()->route('tasks.index')->with('success', 'Tarea actualizada correctamente.');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Tarea eliminada correctamente.');
    }

     /**
     * Retorna todas las tareas en formato JSON (para pruebas backend)
     */
    public function jsonIndex()
    {
        $tasks = \App\Models\Task::with('project')->get();
        return response()->json($tasks);
    }
}
