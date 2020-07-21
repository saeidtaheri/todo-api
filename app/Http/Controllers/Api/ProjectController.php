<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProject;
use App\Http\Requests\UpdateProject;
use App\Http\Resources\ProjectResource;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        return ProjectResource::collection(Project::all());
    }

    public function store(CreateProject $request)
    {
        $project = new Project();
        $project->user_id = $request->user()->id;
        $project->name = $request->name;
        $project->description = $request->description;
        $project->save();

        return new ProjectResource($project);
   }

   public function show(Project $project)
   {
       return new ProjectResource($project);
   }

   public function update(UpdateProject $request, Project $project)
   {
       if($request->user()->id !== $project->user_id) {
           return response()->json([
               'error' => 'You can only edit your own Project.'
           ], 403);
       }

       $project->update($request->all());

       return new ProjectResource($project);
   }

   public function destroy(Request $request, Project $project)
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
