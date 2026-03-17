<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected string $password = 'password123456';

    public function setUp(): void
    {
        parent::setUp();

        $this->withHeaders(['Accept' => 'application/json']);
        $this->user = User::factory()->create(['password' => Hash::make('password123456')]);
    }

    public function test_success_login(): void
    {
        $payload = ['email' => $this->user->email, 'password' => $this->password];

        $response = $this->post('/api/login', $payload);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    public function test_invalid_credentials(): void
    {
        $payload = ['email' => $this->user->email, 'password' => '999999999999999'];

        $response = $this->post('/api/login', $payload);

        $response->assertStatus(401)
            ->assertJson(['success' => false]);
    }

    public function test_invalid_email(): void
    {
        $payload = ['email' => 'qwe', 'password' => '9999999999'];

        $response = $this->post('/api/login', $payload);

        $response->assertStatus(422)
            ->assertJson(['success' => false]);
    }

    public function test_invalid_password(): void
    {
        $payload = ['email' => $this->user->email, 'password' => 'qwe'];

        $response = $this->post('/api/login', $payload);

        $response->assertStatus(422)
            ->assertJson(['success' => false]);
    }

    public function test_empty_email(): void
    {
        $payload = ['password' => 'qwe'];

        $response = $this->post('/api/login', $payload);

        $response->assertStatus(422)
            ->assertJson(['success' => false]);
    }

    public function test_empty_password(): void
    {
        $payload = ['email' => $this->user->email];

        $response = $this->post('/api/login', $payload);

        $response->assertStatus(422)
            ->assertJson(['success' => false]);
    }

    public function test_remember_not_bool(): void
    {
        $payload = ['email' => $this->user->email, 'password' => $this->password, 'remember' => 'ok'];

        $response = $this->post('/api/login', $payload);

        $response->assertStatus(422)
            ->assertJson(['success' => false]);
    }
}
