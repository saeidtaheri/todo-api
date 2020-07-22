<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TodoRequest;
use App\Http\Resources\TodoResource;
use App\Models\Project;
use App\Models\Todo;

class TodoController
{
    public function index()
    {
        return TodoResource::collection(Todo::parentTasks()->get());
    }

    public function show(Todo $todo)
    {
        return new TodoResource($todo);
    }

    public function store(TodoRequest $request, Project $project)
    {
        $project = $project::find($request->project);

        $todo = new Todo();
        $todo->project_id = $project->id;
        $todo->parent_id = $request->parent;
        $todo->title = $request->title;
        $todo->body = $request->body;
        $todo->save();

        return new TodoResource($todo);
    }

    public function update(TodoRequest $request, Todo $todo)
    {
        $todo->update($request->all());

        return new TodoResource($todo);
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();

        return response()->json([
            'success' => 'Todo Has been Deleted!'
        ], 200);
    }
}
