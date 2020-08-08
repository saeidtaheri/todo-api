<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\ClientRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

class ProjectTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function Unauthorized_user_cannot_create_project()
    {
        $params = [
            'name' => 'test',
            'description' => 'testing'
        ];

        $this->json('POST', '/api/projects', $params)
            ->assertStatus(401)
            ->assertUnauthorized();
    }

    /**
     * @test 
     */
    public function name_is_required()
    {
        $user = factory(User::class)->create();

        $params = [
            'user_id' => $user->id,
            'name' => '',
            'description' => 'testing'
        ];

        $this->actingAs($user, 'api')->json('POST', '/api/projects', $params)
            ->assertStatus(422)
            ->assertJson([
                "errors"=> [
                    "name" => [
                        "The name field is required."
                    ]
                ]
            ]);
    }

    /**
     * @test
     */

     public function logged_in_user_can_create_project()
     {
         $user = factory(User::class)->create();
         
         $params = [
            'name' => 'test project',
            'description' => 'testing'
        ];

        $this->actingAs($user, 'api')->json('POST', '/api/projects', $params)
            ->assertStatus(200)
            ->assertJsonCount(1);
     }

     /**
      * @test
      */

      public function unauthorized_user_cannot_edit_project()
      {
        Passport::actingAs(factory(User::class)->create());

        $project = factory(Project::class)->create();

        $project->name = 'test projects';

       $this->json('PUT', '/api/projects/' . $project->id , $project->toArray())
           ->assertStatus(403);
      }

      /**
      * @test
      */
      public function authorized_user_can_edit_project()
      {
        $user = Passport::actingAs(factory(User::class)->create());

        $project = factory(Project::class)->create([
            'user_id' => $user->id
        ]);

        $project->name = 'test projects';

        $this->json('PUT', '/api/projects/' . $project->id , $project->toArray())
           ->assertStatus(200);
      }

      /**
      * @test
      */
      public function unauthorized_user_cannot_delete_project()
      {
        $user = Passport::actingAs(factory(User::class)->create());

        $project = factory(Project::class)->create();

        $this->json('DELETE', '/api/projects/' . $project->id)
           ->assertStatus(403);
      }

      /**
      * @test
      */
      public function authorized_user_can_delete_project()
      {
        $user = Passport::actingAs(factory(User::class)->create());

        $project = factory(Project::class)->create([
            'user_id' => $user->id
            // 'user_id' => Auth::id()
        ]);

        $this->json('DELETE', '/api/projects/' . $project->id)
           ->assertStatus(200);

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
      }
}
