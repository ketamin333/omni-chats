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

        /** @var User $user */
        $this->user = User::factory()->create(['password' => Hash::make('password123456')]);
    }

    public function test_success_login(): void
    {
        $this->post('/api/login', ['email' => $this->user->email, 'password' => $this->password])
            ->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    public function test_invalid_credentials(): void
    {
        $this->post('/api/login', ['email' => $this->user->email, 'password' => '999999999999999'])
            ->assertStatus(401)
            ->assertJson(['success' => false]);
    }

    public function test_invalid_email(): void
    {
        $this->post('/api/login', ['email' => 'qwe', 'password' => '99999999'])
            ->assertStatus(422)
            ->assertJson(['success' => false]);
    }

    public function test_invalid_password(): void
    {
        $this->post('/api/login', ['email' => $this->user->email, 'password' => 'qwe'])
            ->assertStatus(422)
            ->assertJson(['success' => false]);
    }

    public function test_empty_email(): void
    {
        $this->post('/api/login', ['password' => 'qwe'])
            ->assertStatus(422)
            ->assertJson(['success' => false]);
    }

    public function test_empty_password(): void
    {
        $this->post('/api/login', ['email' => $this->user->email])
            ->assertStatus(422)
            ->assertJson(['success' => false]);
    }

    public function test_remember_not_bool(): void
    {
        $this->post('/api/login', ['email' => $this->user->email, 'password' => $this->password, 'remember' => 'ok'])
            ->assertStatus(422)
            ->assertJson(['success' => false]);
    }
}
