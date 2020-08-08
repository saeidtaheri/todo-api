<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use Exception;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Services\ProjectService;

class ProjectController extends Controller
{
    /**
     * @var ProjectService
     */
    private $projectService;

    /**
     * ProjectController constructor.
     * @param ProjectService $projectService
     */
    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    /**
     * @param ProjectService $project
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(ProjectService $project)
    {
        return $this->projectService->all();
    }

    /**
     * @param ProjectRequest $request
     * @return ProjectResource
     * @throws Exception
     */
    public function store(ProjectRequest $request)
    {
        return $this->projectService->create($request);
    }

    /**
     * @param Project $project
     * @return ProjectResource
     */
    public function show(Project $project)
   {
       return $this->projectService->item($project);
   }

    /**
     * @param ProjectRequest $request
     * @param Project $project
     * @return ProjectResource|\Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function update(ProjectRequest $request, Project $project)
   {
        $this->authorize('update', $project);

        return $this->projectService->edit($request, $project);
   }

    /**
     * @param Request $request
     * @param Project $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, Project $project)
   {
        $this->authorize('delete', $project);
        
        return $this->projectService->delete($project, $request);
   }
}
