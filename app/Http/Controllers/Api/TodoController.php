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
    public function index()
    {
        return TodoResource::collection(Todo::parentTasks()->get());
    }

    public function show(Todo $todo)
    {
        return new TodoResource($todo);
    }

    public function store(TodoRequest $request, Project $project)
    {
        $project = $project::find($request->project_id);
        $parent = Todo::findOrFail($request->parent_id);

        $todo = new Todo();
        $todo->project_id   = $project->id;
        $todo->parent_id    = $parent->id;
        $todo->title        = $request->title;
        $todo->body         = $request->body;
        $todo->reminder     = $request->reminder;
        $todo->save();

        $this->addTags($todo, $request->get('tags'));

        return new TodoResource($todo);
    }

    public function update(TodoRequest $request, Todo $todo)
    {
        $todo->update($request->except('tags'));
        $this->addTags($todo, $request->get('tags'));

        return new TodoResource($todo);
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();

        return response()->json([
            'success' => 'Todo Has been Deleted!'
        ], 200);
    }

    public function addTags($todo,$tags)
    {
        if( $tags != "") {
            $tagNames = explode(',', $tags);
            $tagIds = [];

            foreach($tagNames as $tagName)
            {
                $tag = Tag::firstOrCreate(['name'=>$tagName]);
                if($tag) {
                    $tagIds[] = $tag->id;
                }
            }
            $todo->tags()->sync($tagIds);
        }
    }
}
