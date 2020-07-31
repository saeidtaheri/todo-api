<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Http\Requests\UpdateProject;
use App\Http\Resources\ProjectResource;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Services\ProjectService;

class ProjectController extends Controller
{
    /**
     * @param ProjectService $project
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(ProjectService $project)
    {
        return $project->all();
    }

    /**
     * @param ProjectService $project
     * @param ProjectRequest $request
     * @return ProjectResource
     */
    public function store(ProjectService $project, ProjectRequest $request)
    {
        return $project->create($request);
    }

    /**
     * @param ProjectService $projectService
     * @param Project $project
     * @return ProjectResource
     */
    public function show(ProjectService $projectService, Project $project)
   {
       return $projectService->item($project);
   }

    /**
     * @param ProjectService $projectService
     * @param ProjectRequest $request
     * @param Project $project
     * @return ProjectResource|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(ProjectService $projectService, ProjectRequest $request, Project $project)
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
