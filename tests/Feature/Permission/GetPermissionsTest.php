<?php

namespace Tests\Feature\Permission;

use App\Enums\PermissionSlug;
use App\Models\Permission;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetPermissionsTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(PermissionSeeder::class);
        $permission = Permission::where('slug', PermissionSlug::USERS_MANAGE)->first();

        $this->admin = User::factory()->create();
        $this->admin->permissions()->sync([$permission->permission_id]);

        $this->user = User::factory()->create();
    }

    public function test_admin_can_get_permissions(): void
    {
        $response = $this->actingAs($this->admin)
            ->withHeaders(['Referer' => config('app.url')])
            ->getJson('/api/permissions');

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    public function test_user_cannot_get_permissions(): void
    {
        $response = $this->actingAs($this->user)
            ->withHeaders(['Referer' => config('app.url')])
            ->getJson('/api/permissions');

        $response->assertStatus(403)
            ->assertJson(['success' => false]);
    }

    public function test_unauthenticated_user_gets_401(): void
    {
        $response = $this->getJson('/api/permissions');

        $response->assertStatus(401)
            ->assertJson(['success' => false]);
    }

    public function test_response_has_correct_structure(): void
    {
        $response = $this->actingAs($this->admin)
            ->withHeaders(['Referer' => config('app.url')])
            ->getJson('/api/permissions');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['slug', 'label', 'description']
                ]
            ]);
    }
}
