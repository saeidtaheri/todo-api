<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TodoRequest;
use App\Http\Resources\TodoResource;
use App\Models\Project;
use App\Models\Todo;
use App\Services\TodoService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TodoController
{
    /**
     * @var TodoService
     */
    private $todoService;

    /**
     * Inject TodoService to the controller.
     * @param TodoService $todoService
     */
    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return $this->todoService->all();
    }

    /**
     * @param Todo $todo
     * @return TodoResource
     */
    public function show(Todo $todo)
    {
        return $this->todoService->item($todo);
    }

    /**
     * @param TodoRequest $request
     * @param Project $project
     * @return TodoResource
     * @throws Exception
     */
    public function store(TodoRequest $request, Project $project)
    {
        return $this->todoService->create($request, $project);
    }

    /**
     * @param TodoRequest $request
     * @param Todo $todo
     * @return TodoResource
     * @throws Exception
     */
    public function update(TodoRequest $request, Todo $todo)
    {
       return $this->todoService->edit($todo, $request);
    }

    /**
     * @param Todo $todo
     * @return JsonResponse
     */
    public function destroy(Todo $todo)
    {
        return $this->todoService->delete($todo);
    }
}
