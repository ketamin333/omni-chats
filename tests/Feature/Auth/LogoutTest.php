<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_logout(): void
    {
        $this
            ->actingAs(User::factory()->create())
            ->withHeaders(['Referer' => config('app.url')])
            ->postJson('/api/logout')
            ->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    public function test_unauthenticated_user_gets_401(): void
    {
        $this
            ->postJson('/api/logout')
            ->assertStatus(401)
            ->assertJson(['success' => false]);
    }
}
