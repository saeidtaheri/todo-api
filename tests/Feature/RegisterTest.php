<?php

namespace Tests\Feature;

use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_register()
    {
        
        $faker = Factory::create();
        $params = [
            'name' => $faker->title,
            'email' => $faker->email,
            'password' => $faker->password
        ];

        $this->json('POST','/api/register', $params)
            ->assertStatus(201);

    }

    /** @test */
    public function NameEmailAndPasswordRequired() 
    {
        $this->json('POST', '/api/register')
            ->assertStatus(422)
            ->assertJson([
                    "errors"=> [
                        "name" => [
                            "The name field is required."
                        ],
                        "email" => [
                            "The email field is required."
                        ],
                        "password" => [
                            "The password field is required."
                        ]
                    ]
            ]);
    }
}
