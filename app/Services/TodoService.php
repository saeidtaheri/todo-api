<?php


namespace App\Services;


use App\Http\Requests\TodoRequest;
use App\Http\Resources\TodoResource;
use App\Models\Project;
use App\Models\Tag;
use App\Models\Todo;

class TodoService
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function all(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return TodoResource::collection(Todo::parentTasks()->get());
    }

    /**
     * @param Todo $todo
     * @return TodoResource
     */
    public function item(Todo $todo): TodoResource
    {
        return new TodoResource($todo);
    }

    /**
     * @param TodoRequest $request
     * @param Project $projectModel
     * @return TodoResource
     * @throws \Exception
     */
    public function create(TodoRequest $request, Project $projectModel): TodoResource
    {
        $project = $projectModel::find($request->project_id);
        $parent = Todo::findOrFail($request->parent_id);
        $todo   = $request->todo();

        try {
            $todo->project_id   = $project->id;
            $todo->parent_id    = $parent->id;
            $todo->title        = $request->title;
            $todo->body         = $request->body;
            $todo->reminder     = $request->reminder;
            $todo->save();

            $this->addTags($todo, $request->get('tags'));

            return new TodoResource($todo);
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param $todo
     * @param TodoRequest $request
     * @return TodoResource
     * @throws \Exception
     */
    public function edit($todo, TodoRequest $request): TodoResource
    {
        try {
            $todo->update($request->except('tags'));
            $this->addTags($todo, $request->tags);

            return new TodoResource($todo);
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param $todo
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($todo)
    {
        $todo->delete();

        return response()->json([
            'success' => 'Todo Has been Deleted!'
        ], 200);
    }

    /**
     * @param Todo $todo
     * @param $tags
     */
    private function addTags(Todo $todo, $tags)
    {
        if( $tags != "") {
            $tagNames = explode(',', $tags);
            $tagIds = [];

            foreach($tagNames as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                if($tag) {
                    $tagIds[] = $tag->id;
                }
            }
            $todo->tags()->sync($tagIds);
        }
    }
}
