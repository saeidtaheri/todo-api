<?php

namespace Tests\Unit;

use App\Models\Tag;
use Tests\TestCase;
use App\Models\Todo;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodoTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function todo_can_be_created()
    {
        factory(Todo::class)->create();

        $this->assertCount(1, Todo::all());
    }

    /**
     * @test
     */
    public function subTodo_can_be_added()
    {
        $project = factory(Project::class)->create();
        
        $parent = factory(Todo::class)->create([
            'project_id' => $project->id
        ]);

        $todo = factory(Todo::class)->create([
            'project_id' => $project->id,
            'parent_id' => $parent->id
        ]);

        $this->assertCount(2, Todo::all());
    }

    /**
     * @test
     */
     public function todo_can_add_tags()
     {
        $tag = factory(Tag::class)->create();
        $todo = factory(Todo::class)->create();

        $todo->tags()->sync($tag);

        $this->assertInstanceOf(Tag::class, $todo->tags[0]);

        $this->assertCount(1, Todo::all());
        $this->assertCount(1, Tag::all());
     }

     /**
      * @test
      */
     public function todo_can_be_updated()
     {
        $todo = factory(Todo::class)->create();

        $params = [
            'title' => 'updated',
            'body' => 'updated Body'
        ];

        $todo->update($params);

        $this->assertEquals('updated', Todo::first()->title);
        $this->assertEquals('updated Body', Todo::first()->body);
     }

     /**
      * @test
      */
     public function todo_can_be_deleted()
     {
         $todo = factory(Todo::class)->create();

         $todo->delete();

         $this->assertCount(0, Todo::all());
     }
}
