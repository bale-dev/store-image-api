<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class StoreImage extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_the_user_register_endpoint(): void
    {
    
        // Define post data
        $registerUserData = [
            "name"      => "Test",
            "email"     => "test4@agildrop.si",
            "password"  => "agildrop"
        ];

        // Test user registration
        $response = $this->post('/api/v1/auth/register', $registerUserData);

        // Assert/make shure, that the status was successful
        $response->assertStatus(200);

        // Assert, that user was created
        $this->assertDatabaseHas('users', [
            'name' => $registerUserData['name'],
            'email' => $registerUserData['email'],
        ]);
    }

    public function test_the_user_login_endpoint(): void 
    {

        // Define post data
        $loginUserData = [
            "email"     => "test4@agildrop.si",
            "password"  => "agildrop"
        ];

        // Test user registration
        $response = $this->post('/api/v1/auth/login', $loginUserData);

        // Assert/make shure, that the status was successful
        $response->assertStatus(200);

    }


}
