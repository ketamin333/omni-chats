<?php

namespace Tests\Feature\User;

use App\Enums\PermissionSlug;
use App\Models\Permission;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdateUserAvatarTest extends TestCase
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

    public function test_admin_can_update_user_avatar(): void
    {
        Storage::fake('public');

        $response = $this->actingAs($this->admin)
            ->withHeaders(['Referer' => config('app.url')])
            ->postJson("/api/users/{$this->target->user_id}/avatar", [
                'avatar' => UploadedFile::fake()->image('avatar.jpg'),
            ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    public function test_invalid_file_type_returns_422(): void
    {
        Storage::fake('public');

        $response = $this->actingAs($this->admin)
            ->withHeaders(['Referer' => config('app.url')])
            ->postJson("/api/users/{$this->target->user_id}/avatar", [
                'avatar' => UploadedFile::fake()->create('file.pdf', 100, 'application/pdf'),
            ]);

        $response->assertStatus(422)
            ->assertJson(['success' => false]);
    }

    public function test_file_exceeds_max_size_returns_422(): void
    {
        Storage::fake('public');

        $response = $this->actingAs($this->admin)
            ->withHeaders(['Referer' => config('app.url')])
            ->postJson("/api/users/{$this->target->user_id}/avatar", [
                'avatar' => UploadedFile::fake()->image('avatar.jpg')->size(3000),
            ]);

        $response->assertStatus(422)
            ->assertJson(['success' => false]);
    }

    public function test_unauthenticated_user_gets_401(): void
    {
        $response = $this->postJson("/api/users/{$this->target->user_id}/avatar");

        $response->assertStatus(401)
            ->assertJson(['success' => false]);
    }

    public function test_user_cannot_update_another_user_avatar(): void
    {
        Storage::fake('public');
        $target = User::factory()->for($this->user->company)->create();

        $response = $this->actingAs($this->user)
            ->withHeaders(['Referer' => config('app.url')])
            ->postJson("/api/users/{$target->user_id}/avatar", [
                'avatar' => UploadedFile::fake()->image('avatar.jpg'),
            ]);

        $response->assertStatus(403)
            ->assertJson(['success' => false]);
    }
}
