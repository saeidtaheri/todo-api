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
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return ProjectResource::collection(Project::all());
    }

    /**
     * @param CreateProject $request
     * @return ProjectResource
     */
    public function store(CreateProject $request)
    {
        try {
            $request->project()->save();

            return new ProjectResource($request->project());
        }catch (\Exception $e) {
            dd($e);
        }
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
     * @param UpdateProject $request
     * @param Project $project
     * @return ProjectResource|\Illuminate\Http\JsonResponse
     */
    public function update(UpdateProject $request, Project $project)
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

       }
   }

    /**
     * @param Request $request
     * @param Project $project
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
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
