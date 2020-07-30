<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TodoRequest;
use App\Http\Resources\TodoResource;
use App\Models\Project;
use App\Models\Tag;
use App\Models\Todo;
use App\Services\TodoService;
use Carbon\Carbon;

class TodoController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return TodoResource::collection(Todo::parentTasks()->get());
    }

    /**
     * @param Todo $todo
     * @return TodoResource
     */
    public function show(Todo $todo)
    {
        return new TodoResource($todo);
    }

    /**
     * @param TodoService $todo
     * @param TodoRequest $request
     * @param Project $project
     * @return TodoResource
     * @throws \Exception
     */
    public function store(TodoService $todo, TodoRequest $request, Project $project)
    {
        return $todo->create($request, $project);
    }

    /**
     * @param TodoService $todoService
     * @param TodoRequest $request
     * @param Todo $todo
     * @return TodoResource
     * @throws \Exception
     */
    public function update(TodoService $todoService, TodoRequest $request, Todo $todo)
    {
       return $todoService->edit($todo, $request);
    }

    /**
     * @param TodoService $todoService
     * @param Todo $todo
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(TodoService $todoService, Todo $todo)
    {
        return $todoService->delete($todo);
    }
}
