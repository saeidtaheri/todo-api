<?php


namespace App\Services;

use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;

class ProjectService
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function all(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ProjectResource::collection(Project::all());
    }

    /**
     * @param Project $project
     * @return ProjectResource
     */
    public function item(Project $project): ProjectResource
    {
        return new ProjectResource($project);
    }

    /**
     * @param ProjectRequest $request
     * @return ProjectResource
     * @throws \Exception
     */
    public function create(ProjectRequest $request): ProjectResource
    {
        try {
            $request->project()->save();

            return new ProjectResource($request->project());
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param ProjectRequest $request
     * @param $project
     * @return ProjectResource|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function edit(ProjectRequest $request, $project)
    {
        try {
            $project->update($request->all());

            return new ProjectResource($project);
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param $project
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($project, $request)
    {
        $project->delete();

        return response()->json([
            'success' => 'Project Has been Deleted!'
        ], 200);
    }
}
