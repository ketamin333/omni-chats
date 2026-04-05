<?php

namespace Tests\Feature\User;

use App\Enums\PermissionSlug;
use App\Events\UserUpdated;
use App\Models\Permission;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $user;
    protected User $target;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(PermissionSeeder::class);
        $permission = Permission::where('slug', PermissionSlug::USERS_MANAGE)->first();

        $this->admin = User::factory()->create();
        $this->admin->permissions()->sync([$permission->permission_id]);

        $this->user = User::factory()->create();
        $this->target = User::factory()->for($this->admin->company)->create();
    }

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'username' => 'Updated Name',
            'phone' => '(999) 123-45-67',
            'permissions' => [PermissionSlug::USERS_MANAGE->value],
        ], $overrides);
    }

    public function test_admin_can_update_user(): void
    {
        $response = $this->actingAs($this->admin)
            ->withHeaders(['Referer' => config('app.url')])
            ->patchJson("/api/users/{$this->target->user_id}", $this->payload());

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    public function test_user_cannot_update_another_user(): void
    {
        $target = User::factory()->for($this->user->company)->create();

        $response = $this->actingAs($this->user)
            ->withHeaders(['Referer' => config('app.url')])
            ->patchJson("/api/users/{$target->user_id}", $this->payload());

        $response->assertStatus(403)
            ->assertJson(['success' => false]);
    }

    public function test_admin_cannot_update_user_from_another_company(): void
    {
        $response = $this->actingAs($this->admin)
            ->withHeaders(['Referer' => config('app.url')])
            ->patchJson("/api/users/{$this->user->user_id}", $this->payload());

        $response->assertStatus(404)
            ->assertJson(['success' => false]);
    }

    public function test_username_max_length_validation(): void
    {
        $response = $this->actingAs($this->admin)
            ->withHeaders(['Referer' => config('app.url')])
            ->patchJson("/api/users/{$this->target->user_id}", $this->payload([
                'username' => str_repeat('a', 256)
            ]));

        $response->assertStatus(422)
            ->assertJson(['success' => false]);
    }

    public function test_invalid_permission_slug_returns_422(): void
    {
        $response = $this->actingAs($this->admin)
            ->withHeaders(['Referer' => config('app.url')])
            ->patchJson("/api/users/{$this->target->user_id}", $this->payload([
                'permissions' => ['invalid.permission']
            ]));

        $response->assertStatus(422)
            ->assertJson(['success' => false]);
    }

    public function test_user_updated_event_is_dispatched(): void
    {
        Event::fake();

        $this->actingAs($this->admin)
            ->withHeaders(['Referer' => config('app.url')])
            ->patchJson("/api/users/{$this->target->user_id}", $this->payload());

        Event::assertDispatched(UserUpdated::class, fn($e) => $e->user->user_id === $this->target->user_id);
    }

    public function test_unauthenticated_user_gets_401(): void
    {
        $response = $this->patchJson("/api/users/{$this->target->user_id}", $this->payload());

        $response->assertStatus(401)
            ->assertJson(['success' => false]);
    }
}
