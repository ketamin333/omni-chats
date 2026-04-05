<?php

namespace Tests\Feature\User;

use App\Enums\PermissionSlug;
use App\Models\Permission;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
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
        $this->seed(PermissionSeeder::class);
        $permission = Permission::where('slug', PermissionSlug::USERS_MANAGE)->first();

        $this->admin = User::factory()->create();
        $this->admin->permissions()->sync([$permission->permission_id]);

        $this->user = User::factory()->create();
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

    public function test_returns_404_for_nonexistent_user(): void
    {
        $response = $this->actingAs($this->admin)
            ->withHeaders(['Referer' => config('app.url')])
            ->getJson('/api/users/999999');

        $response->assertStatus(404)
            ->assertJson(['success' => false]);
    }

    public function test_response_has_correct_structure(): void
    {
        $user = User::factory()->for($this->admin->company)->create();

        $response = $this->actingAs($this->admin)
            ->withHeaders(['Referer' => config('app.url')])
            ->getJson("/api/users/{$user->user_id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'user_id',
                    'username',
                    'email',
                    'phone',
                    'avatar_url',
                    'permissions',
                    'timestamps' => ['created_at', 'last_login_at'],
                ]
            ]);
    }
}
