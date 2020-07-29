<?php


namespace App\Services;


use App\Http\Requests\CreateProject;
use App\Http\Resources\ProjectResource;

class Project
{
    public function create(CreateProject $request)
    {
        try {
            $project = new \App\Models\Project();
            $project->user_id = $request->user()->id;
            $project->name = $request->name;
            $project->description = $request->description;
            $project->save();



            return new ProjectResource($project);
        }catch (\Exception $e) {

        }
    }
}
