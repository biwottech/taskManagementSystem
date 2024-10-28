<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TaskController extends Controller
{
  // Get all tasks with filtering, pagination, and search functionality
  public function index(Request $request)
  {
    $query = Task::query();

    // Filter by status 
    if ($request->has('status')) {
      $query->where('status', $request->status);
    }

    // Filter by due_date
    if ($request->has('due_date')) {
      $query->where('due_date', $request->due_date);
    }

    // Search by title
    if ($request->has('search')) {
      $query->where('title', 'like', '%' . $request->search . '%');
    }

    // Paginate the results
    $tasks = $query->paginate(10);

    return response()->json($tasks);
  }

  // Create a new task
  public function store(Request $request)
  {
    $this->validate($request, [
      'title' => 'required|string|unique:tasks,title|max:255',
      'description' => 'nullable|string',
      'status' => 'in:pending,completed',
      'due_date' => 'required|date|after:today',
    ]);

    $task = Task::create($request->only(['title', 'description', 'status', 'due_date']));

    return response()->json($task, 201);
  }

  // Get a specific task
  public function show($id)
  {
    $task = Task::find($id);

    if (!$task) {
      return response()->json(['message' => 'Task not found'], 404);
    }

    return response()->json($task);
  }

  // Update a task
  public function update(Request $request, $id)
  {
    $task = Task::find($id);

    if (!$task) {
      return response()->json(['message' => 'Task not found'], 404);
    }

    $this->validate($request, [
      'title' => 'sometimes|required|string|unique:tasks,title,' . $id . '|max:255',
      'description' => 'nullable|string',
      'status' => 'in:pending,completed',
      'due_date' => 'sometimes|required|date|after:today',
    ]);

    $task->update($request->only(['title', 'description', 'status', 'due_date']));

    return response()->json($task);
  }

  // Delete a task
  public function destroy($id)
  {
    $task = Task::find($id);

    if (!$task) {
      return response()->json(['message' => 'Task not found'], 404);
    }

    $task->delete();

    return response()->json(['message' => 'Task deleted successfully']);
  }
}
