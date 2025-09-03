<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    public function index()
    {
        return TaskResource::collection(Task::with('project')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
            'project_id' => 'required|exists:projects,id',
        ]);
        $task = Task::create($validated);
        return new TaskResource($task->load('project'));
    }

    public function show(Task $task)
    {
        return new TaskResource($task->load('project'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'status' => 'sometimes|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
            'project_id' => 'sometimes|required|exists:projects,id',
        ]);
        $task->update($validated);
        return new TaskResource($task->load('project'));
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(null, 204);
    }
}
