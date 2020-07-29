<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TodoRequest;
use App\Http\Resources\TodoResource;
use App\Models\Project;
use App\Models\Tag;
use App\Models\Todo;
use Carbon\Carbon;

class TodoController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return TodoResource::collection(Todo::parentTasks()->get());
    }

    /**
     * @param Todo $todo
     * @return TodoResource
     */
    public function show(Todo $todo)
    {
        return new TodoResource($todo);
    }

    /**
     * @param TodoRequest $request
     * @param Project $project
     * @return TodoResource
     */
    public function store(TodoRequest $request, Project $project)
    {
        $project = $project::find($request->project_id);
        $parent = Todo::findOrFail($request->parent_id);

        try {
            $todo = new Todo();
            $todo->project_id   = $project->id;
            $todo->parent_id    = $parent->id;
            $todo->title        = $request->title;
            $todo->body         = $request->body;
            $todo->reminder     = $request->reminder;
            $todo->save();

            $this->addTags($todo, $request->get('tags'));

            return new TodoResource($todo);
        }catch (\Exception $e){

        }
    }

    /**
     * @param TodoRequest $request
     * @param Todo $todo
     * @return TodoResource
     */
    public function update(TodoRequest $request, Todo $todo)
    {
        try {
            $todo->update($request->except('tags'));
            $this->addTags($todo, $request->get('tags'));

            return new TodoResource($todo);
        }catch (\Exception $e){
    
        }
    }

    /**
     * @param Todo $todo
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();

        return response()->json([
            'success' => 'Todo Has been Deleted!'
        ], 200);
    }

    /**
     * @param $todo
     * @param $tags
     */
    public function addTags($todo, $tags)
    {
        if( $tags != "") {
            $tagNames = explode(',', $tags);
            $tagIds = [];

            foreach($tagNames as $tagName) {
                $tag = Tag::firstOrCreate(['name'=>$tagName]);
                if($tag) {
                    $tagIds[] = $tag->id;
                }
            }
            $todo->tags()->sync($tagIds);
        }
    }
}
