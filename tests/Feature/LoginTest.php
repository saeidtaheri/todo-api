<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\ClientRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $clientRepository = new ClientRepository();
        $this->client = $clientRepository->createPersonalAccessClient(
            null, 'Test Personal Access Client', '/'
        );
        DB::table('oauth_personal_access_clients')->insert([
            'client_id' => $this->client->id,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);
        $this->user = User::create([
            'id' => 1,
            'name' => 'test',
            'lastname' => 'er',
            'email' => 'test@test.test',
            'password' => bcrypt('secret')
        ]);
        $this->token = $this->user->createToken('TestToken', [])->accessToken;
    }

    /** @test */
    public function EmailAndPasswordRequired()
    {
        $body = [
            'email' => '',
            'password' => ''
        ];

        $this->json('POST', '/api/login', $body)
            ->assertStatus(422)
            ->assertJson([
                "errors" => [
                    "email" => [
                        "The email field is required."
                    ],
                    "password" => [
                        "The password field is required."
                    ]
                ]
            ]);
    }

    /**
     * @test
     */
    public function user_cannot_login_with_incorrect_password()
    {
        $body = [
            'client_id' => (string) $this->client->id,
            'client_secret' => $this->client->secret,
            'email' => 'test@test.test',
            'password' => 'invalid password',
        ];

        $this->json('POST', '/api/login', $body)
            ->assertStatus(401)
            ->assertJson([
                    "errors" => "Incorrect email or password!"
            ]);

    }

    /**
     * @test
     */
    public function user_can_login()
    {
        $body = [
            'client_id' => (string) $this->client->id,
            'client_secret' => $this->client->secret,
            'email' => 'test@test.test',
            'password' => 'secret',
        ];

        $this->json('POST', '/api/login', $body, ['Accept' => 'application/json'])
        ->assertStatus(200)
        ->assertJsonStructure([
                'success' => [
                    'token',
                ]
        ]);

        $this->assertAuthenticatedAs($this->user);
    }
}
