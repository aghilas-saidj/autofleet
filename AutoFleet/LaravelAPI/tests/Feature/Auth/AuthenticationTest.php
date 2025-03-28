<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create([
            'role' => 'customer',
            'password' => bcrypt('password'),
        ]);


        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);


        $response->assertStatus(200);
        $this->assertAuthenticated();
        $this->assertEquals('customer', $user->role);

        $response->assertJsonStructure([
            'token',
            'id',
            'name',
            'email',
            'role',
        ]);



    }


    

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create([
            'role' => 'customer',
            'password' => bcrypt('password'),
        ]);



        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }



    // public function test_users_can_logout(): void
    // {
    //     $user = User::factory()->create([
    //         'role' => 'customer',
    //         'password' => bcrypt('password'),
    //     ]);


    //     $response = $this->actingAs($user)->post('/api/logout');

    //     $this->assertGuest();
    //     $response->assertNoContent();
    // }
}
