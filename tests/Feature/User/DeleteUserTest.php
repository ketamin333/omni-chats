<?php

namespace Tests\Feature\User;

use App\Enums\PermissionSlug;
use App\Events\UserDeleted;
use App\Models\Company;
use App\Models\Permission;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class DeleteUserTest extends TestCase
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

    public function test_admin_can_delete_user(): void
    {
        $response = $this->actingAs($this->admin)
            ->delete("/api/users/{$this->target->user_id}");

        $response->assertStatus(204)
            ->assertNoContent();
    }

    public function test_user_cannot_delete_other_user(): void
    {
        $target = User::factory()->for($this->user->company)->create();

        $response = $this->actingAs($this->user)
            ->delete("/api/users/{$target->user_id}");

        $response->assertStatus(403)
            ->assertJson(['success' => false]);
    }

    public function test_unauthenticated_user_gets_401(): void
    {
        $response = $this->deleteJson("/api/users/{$this->target->user_id}");

        $response->assertStatus(401)
            ->assertJson(['success' => false]);
    }

    public function test_user_not_found_gets_404(): void
    {
        $response = $this->actingAs($this->admin)
            ->delete('/api/users/555');

        $response->assertStatus(404)
            ->assertJson(['success' => false]);
    }

    public function test_user_from_other_company_gets_404(): void
    {
        $otherCompany = Company::factory()->create();
        $this->target->update(['company_id' => $otherCompany->company_id]);

        $response = $this->actingAs($this->admin)
            ->delete("/api/users/{$this->target->user_id}");

        $response->assertStatus(404)
            ->assertJson(['success' => false]);
    }

    public function test_deleted_user_is_soft_deleted(): void
    {
        $response = $this->actingAs($this->admin)
            ->delete("/api/users/{$this->target->user_id}");

        $response->assertStatus(204)
            ->assertNoContent();

        $this->assertSoftDeleted('users', [
            'user_id' => $this->target->user_id,
        ]);
    }

    public function test_user_deleted_event_is_dispatched(): void
    {
        Event::fake();

        $this->actingAs($this->admin)
            ->delete("/api/users/{$this->target->user_id}");

        Event::assertDispatched(UserDeleted::class, function ($event) {
            return $event->user->user_id === $this->target->user_id;
        });
    }
}
