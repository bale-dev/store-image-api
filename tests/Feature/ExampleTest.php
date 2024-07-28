<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */

    protected $token = 'Bearer {}';


    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    
    public function test_the_user_register_endpoint(): void
    {
    
        // Define post data
        $registerUserData = [
            "name"      => "Test",
            "email"     => "test7@agildrop.si",
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
    	
    public function test_the_user_login_endpoint() 
    {

        // Define post data
        $loginUserData = [
            "email"     => "test7@agildrop.si",
            "password"  => "agildrop"
        ];

        // Test user registration
        $response = $this->post('/api/v1/auth/login', $loginUserData);

        // Assert/make shure, that the status was successful
        $response->assertStatus(200);

        //return $response->getData()['token'];

    }

    
    public function test_store_image_endpoint(): void
    {

        $imageData = [
            'image_name' => 'test',
            'image_description' => 'test d',
            'image_file' => 'C:\Users\Master\Downloads\hero-logos-image.png'
        ];

        $bearerToken = $this->token;
        
        $response = $this->withHeaders([
            'Authorization' => $bearerToken,

            ])->post('/api/v1/store-image', $imageData);
            
        $response->assertStatus(200);
        
    }
    
}
