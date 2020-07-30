<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProject;
use App\Http\Requests\UpdateProject;
use App\Http\Resources\ProjectResource;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Services\ProjectService;

class ProjectController extends Controller
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return ProjectResource::collection(Project::all());
    }

    /**
     * @param ProjectService $project
     * @param CreateProject $request
     * @return ProjectResource
     */
    public function store(ProjectService $project, CreateProject $request)
    {
        return $project->create($request);
    }

    /**
     * @param Project $project
     * @return ProjectResource
     */
    public function show(Project $project)
   {
       return new ProjectResource($project);
   }

    /**
     * @param ProjectService $projectService
     * @param UpdateProject $request
     * @param Project $project
     * @return ProjectResource|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(ProjectService $projectService, UpdateProject $request, Project $project)
   {
       return $projectService->edit($request, $project);
   }

    /**
     * @param ProjectService $projectService
     * @param Request $request
     * @param Project $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ProjectService $projectService, Request $request, Project $project)
   {
        return $projectService->delete($project, $request);
   }
}
