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
     * @param TodoService $todo
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(TodoService $todo)
    {
        return $todo->all();
    }

    /**
     * @param TodoService $todoService
     * @param Todo $todo
     * @return TodoResource
     */
    public function show(TodoService $todoService, Todo $todo)
    {
        return $todoService->item($todo);
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
