<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'customer',
            'password' => 'password', // plain text
            'password_confirmation' => 'password', // plain text
        ]);

        $response->assertStatus(201);
    // Find the user that was just created
    $user = User::where('email', 'test@example.com')->first();

    // Log the user in
    $this->actingAs($user);

    // Assert that the user is authenticated
    $this->assertAuthenticated();
    }
}
