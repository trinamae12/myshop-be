<?php

namespace Tests\Unit;

use Tests\TestCase; 
use App\Models\User;
use Laravel\Passport\Passport;

class UserTest extends TestCase
{

    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    /**
     * Test new users can register successfully
     */
    public function test_successful_register() {
        $userData = [
            "name" => "Test User",
            "email" => "testuser@email.com",
            "password" => "password",
        ];

        $this->json('POST', 'api/register', $userData)
            ->assertStatus(201)
            ->assertJsonStructure([
                "success",
                "token",
                "user" => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }

    /**
     * Blank name
     */
    public function test_registration_blank_name() {
        $userData = [
            "name" => "",
            "email" => "user@email.com",
            "password" => "password",
        ];

        $this->json('POST', 'api/register', $userData)
        ->assertStatus(403)
        ->assertJsonValidationErrors(['name' => 'The name field is required.']);
    }

    /**
     * Blank email
     */
    public function test_registration_blank_email() {
        $userData = [
            "name" => "Test Another User",
            "email" => "",
            "password" => "password",
        ];

        $this->json('POST', 'api/register', $userData)
        ->assertStatus(403)
        ->assertJsonValidationErrors(['email' => 'The email field is required.']);
    }

    /**
     * Blank password
     */
    public function test_registration_blank_password() {
        $userData = [
            "name" => "Test Another User",
            "email" => "user@email.com",
            "password" => "",
        ];

        $this->json('POST', 'api/register', $userData)
        ->assertStatus(403)
        ->assertJsonValidationErrors(['password' => 'The password field is required.']);
    }

    /**
     * Test registration if email is already taken
     */
    public function test_registration_taken_email() {
        $userData = [
            "name" => "Test Another User",
            "email" => "admin@email.com",
            "password" => "password",
        ];

        $this->json('POST', 'api/register', $userData)
            ->assertStatus(403)
            ->assertJsonValidationErrors(['email' => 'The email has already been taken.']);
    }

    /**
     * Test registration if email is in wrong format
     */
    public function test_registration_email_wrong_format() {
        $userData = [
            "name" => "Test Another User",
            "email" => "admin@com",
            "password" => "password",
        ];

        $this->json('POST', 'api/register', $userData)
            ->assertStatus(403)
            ->assertJsonValidationErrors(['email' => 'The email field must be a valid email address.']);
    }

    /**
     * Test get all users successfully
     */
    public function test_get_all_users_successfully() {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $this->json('GET', 'api/users')->assertStatus(200);
    }

    /**
     * Test get all users but not logged in
     */
    public function test_get_all_users_not_logged_in() {
        $this->json('GET', 'api/users')->assertStatus(401);
    }

    /**
     * Test login successfully
     */
    public function test_login_successful() {
        $userData = [
            "email" => "admin@email.com",
            "password" => "password"
        ];

        $this->json('POST', 'api/login', $userData)->assertStatus(200);
    }

    /**
     * Test login incorrect credentials
     */
    public function test_login_incorrect_credentials() {
        $userData = [
            "email" => "admin@email.com",
            "password" => "password123"
        ];

        $this->json('POST', 'api/login', $userData)->assertStatus(401);
    }

    /**
     * Test login blank email
     */
    public function test_login_blank_email() {
        $userData = [
            "email" => "",
            "password" => "password123"
        ];

        $this->json('POST', 'api/login', $userData)
            ->assertStatus(403)
            ->assertJsonValidationErrors(['email' => 'The email field is required']);
    }

    /**
     * Test login blank email
     */
    public function test_login_blank_password() {
        $userData = [
            "email" => "admin@email.com",
            "password" => ""
        ];

        $this->json('POST', 'api/login', $userData)
            ->assertStatus(403)
            ->assertJsonValidationErrors(['password' => 'The password field is required']);
    }
}
