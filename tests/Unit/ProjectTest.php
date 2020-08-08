<?php

namespace Tests\Unit;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_project_can_be_created()
    {
        factory(Project::class)->create();

        $this->assertCount(1, Project::all());
        $this->assertEquals(1, Project::first()->user_id);
    }

    /**
     * @test
     */
    public function a_project_can_be_updated()
    {
        $project = factory(Project::class)->create();

        $params = [
            'name' => 'test',
            'description' => 'testing',
        ];

        $project->update($params);

        $this->assertEquals('test', $project::first()->name);
        $this->assertEquals('testing', $project::first()->description);
    }

    /**
     * @test
     */
    public function a_project_can_be_deleted()
    {
        $project = factory(Project::class)->create();

        $project->delete($project);

        $this->assertCount(0, $project::all());
    }
}
