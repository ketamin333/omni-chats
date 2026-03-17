<?php

namespace Tests\Feature\User;

use App\Enums\Role;
use App\Models\Company;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetUserTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);

        $this->admin = User::factory()->create();
        $this->admin->assignRole(Role::ADMIN);

        $this->user = User::factory()->create();
        $this->user->assignRole(Role::USER);
    }

    public function test_admin_can_get_user(): void
    {
        $user = User::factory()->for($this->admin->company)->create();

        $response = $this->actingAs($this->admin)
            ->withHeaders(['Referer' => config('app.url')])
            ->get("/api/users/$user->user_id");

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    public function test_admin_cannot_get_user_from_another_company(): void
    {
        $response = $this->actingAs($this->admin)
            ->withHeaders(['Referer' => config('app.url')])
            ->get("/api/users/{$this->user->user_id}");

        $response->assertStatus(404)
            ->assertJson(['success' => false]);
    }

    public function test_user_can_get_own_profile(): void
    {
        $response = $this->actingAs($this->user)
            ->withHeaders(['Referer' => config('app.url')])
            ->get("/api/users/{$this->user->user_id}");

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    public function test_user_cannot_get_another_user_profile(): void
    {
        $user = User::factory()->for($this->user->company)->create();

        $response = $this->actingAs($this->user)
            ->withHeaders(['Referer' => config('app.url')])
            ->get("/api/users/$user->user_id");

        $response->assertStatus(403)
            ->assertJson(['success' => false]);
    }

    public function test_unauthenticated_user_gets_401(): void
    {
        $response = $this->getJson('/api/users/1');

        $response->assertStatus(401)
            ->assertJson(['success' => false]);
    }
}
