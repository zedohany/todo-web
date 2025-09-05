<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Priority;
use App\Models\Category;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::where('user_id', auth()->id())->with(['priority', 'category'])->get();

        return Inertia::render('task/Index')->with([
            'tasks' => $tasks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $priorities = Priority::where('user_id', auth()->id())->get();
        $categories = Category::where('user_id', auth()->id())->get();

        return Inertia::render('task/Create')->with([
            'priorities' => $priorities,
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'priority_id' => 'required',
            'category_id' => 'required',
            'image' => 'nullable|image|max:2048', // Max 2MB
        ]);

        if (!Priority::where('id', $validated['priority_id'])->exists()) {
            return back()->withErrors(['priority_id' => 'Invalid priority selected.'])->withInput();
        }
        if (!Category::where('id', $validated['category_id'])->exists()) {
            return back()->withErrors(['category_id' => 'Invalid category selected.'])->withInput();
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if (!$file->isValid()) {
                return back()->withErrors(['image' => 'Uploaded image is not valid.'])->withInput();
            }
        }

        if ($validated['deadline'] && strtotime($validated['deadline']) < time()) {
            return back()->withErrors(['deadline' => 'The deadline must be a future date.'])->withInput();
        }

        $task = new Task();
        $task->title = $validated['title'];
        $task->description = $validated['description'] ?? null;
        $task->deadline = $validated['deadline'] ?? null;
        $task->priority_id = $validated['priority_id'];
        $task->category_id = $validated['category_id'];
        $task->user_id = auth()->id();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('tasks', 'public');
            $task->image = $path;
        }
        $task->save();

        return to_route('tasks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }

    public function updateStatus(Request $request, Task $task)
    {
        $task->status = 'completed';
        $task->save();

        $tasks = Task::where('user_id', auth()->id())->with(['priority', 'category'])->get();

        return redirect()->route('tasks.index')->with('success', 'Task status updated successfully.');
    }
}
