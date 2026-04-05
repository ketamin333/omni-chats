<?php

namespace Tests\Feature\User;

use App\Enums\PermissionSlug;
use App\Models\Permission;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChangeUserPasswordTest extends TestCase
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
            'password' => 'NewPassword123AAAASDSAD',
            'password_confirmation' => 'NewPassword123AAAASDSAD',
        ], $overrides);
    }

    public function test_admin_can_change_user_password(): void
    {
        $response = $this->actingAs($this->admin)
            ->withHeaders(['Referer' => config('app.url')])
            ->putJson("/api/users/{$this->target->user_id}/password", $this->payload());

        $response->assertStatus(204);
    }

    public function test_user_cannot_change_another_user_password(): void
    {
        $target = User::factory()->for($this->user->company)->create();

        $response = $this->actingAs($this->user)
            ->withHeaders(['Referer' => config('app.url')])
            ->putJson("/api/users/{$target->user_id}/password", $this->payload());

        $response->assertStatus(403)
            ->assertJson(['success' => false]);
    }

    public function test_admin_cannot_change_password_of_user_from_another_company(): void
    {
        $response = $this->actingAs($this->admin)
            ->withHeaders(['Referer' => config('app.url')])
            ->putJson("/api/users/{$this->user->user_id}/password", $this->payload());

        $response->assertStatus(404)
            ->assertJson(['success' => false]);
    }

    public function test_password_not_confirmed_returns_422(): void
    {
        $response = $this->actingAs($this->admin)
            ->withHeaders(['Referer' => config('app.url')])
            ->putJson("/api/users/{$this->target->user_id}/password", $this->payload([
                'password_confirmation' => 'NewPassword123AAAASDSADASDASD',
            ]));

        $response->assertStatus(422)
            ->assertJson(['success' => false]);
    }

    public function test_weak_password_returns_422(): void
    {
        $response = $this->actingAs($this->admin)
            ->withHeaders(['Referer' => config('app.url')])
            ->putJson("/api/users/{$this->target->user_id}/password", $this->payload([
                'password' => '123',
                'password_confirmation' => '123',
            ]));

        $response->assertStatus(422)
            ->assertJson(['success' => false]);
    }

    public function test_unauthenticated_user_gets_401(): void
    {
        $response = $this->putJson("/api/users/{$this->target->user_id}/password", $this->payload());

        $response->assertStatus(401)
            ->assertJson(['success' => false]);
    }
}
