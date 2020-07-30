<?php


namespace App\Services;

use App\Http\Requests\ProjectRequest;
use App\Http\Requests\UpdateProject;
use App\Http\Resources\ProjectResource;
use App\Models\Project;

class ProjectService
{
    public function create(ProjectRequest $request)
    {
        try {
            $request->project()->save();

            return new ProjectResource($request->project());
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function edit(UpdateProject $request, $project)
    {
        if($request->user()->id !== $project->user_id) {
            return response()->json([
                'error' => 'You can only edit your own Project.'
            ], 403);
        }

        try {
            $project->update($request->all());

            return new ProjectResource($project);
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function delete($project, $request)
    {
        if($request->user()->id !== $project->user_id) {
            return response()->json([
                'error' => 'You Cant Delete Project!'
            ], 403);
        }

        $project->delete();

        return response()->json([
            'success' => 'Project Has been Deleted!'
        ], 200);
    }
}
