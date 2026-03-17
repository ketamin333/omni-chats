<?php

namespace Tests\Feature\User;

use App\Enums\Role;
use App\Models\Company;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $user;
    protected User $target;
    protected UploadedFile $file;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);
        Storage::fake('public');
        $this->file = UploadedFile::fake()->image('avatar.jpg');

        $this->admin = User::factory()->create();
        $this->admin->assignRole(Role::ADMIN);

        $this->user = User::factory()->create(['company_id' => $this->admin->company_id]);
        $this->user->assignRole(Role::USER);

        $this->target = User::factory()->create(['company_id' => $this->admin->company_id]);
        $this->target->assignRole(Role::USER);
    }

    private function payload(array $overrides = []): array
    {
        return array_merge(['username' => 'test'], $overrides);
    }

    public function test_admin_can_update_user(): void
    {
        $payload = $this->payload(['phone' => null]);

        $response = $this->actingAs($this->admin)
            ->patch("/api/users/{$this->target->user_id}", $payload);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    public function test_update_only_one_field(): void
    {
        $payload = $this->payload();

        $response = $this->actingAs($this->admin)
            ->patch("/api/users/{$this->target->user_id}", $payload);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    public function test_update_with_avatar(): void
    {
        $payload = $this->payload(['avatar' => $this->file]);

        $response = $this->actingAs($this->admin)
            ->patch("/api/users/{$this->target->user_id}", $payload);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    public function test_user_cannot_update_other_user(): void
    {
        $payload = $this->payload();

        $response = $this->actingAs($this->user)
            ->patch("/api/users/{$this->target->user_id}", $payload);

        $response->assertStatus(403)
            ->assertJson(['success' => false]);
    }

    public function test_unauthenticated_user_gets_401(): void
    {
        $payload = $this->payload();

        $response = $this->patchJson("/api/users/{$this->target->user_id}", $payload);

        $response->assertStatus(401)
            ->assertJson(['success' => false]);
    }

    public function test_user_not_found_gets_404(): void
    {
        $payload = $this->payload();

        $response = $this->actingAs($this->admin)
            ->patch('/api/users/555', $payload);

        $response->assertStatus(404)
            ->assertJson(['success' => false]);
    }

    public function test_user_from_other_company_gets_404(): void
    {
        $company = Company::factory()->create();
        $this->target->update(['company_id' => $company->company_id]);
        $payload = $this->payload();

        $response = $this->actingAs($this->admin)
            ->patch("/api/users/{$this->target->user_id}", $payload);

        $response->assertStatus(404)
            ->assertJson(['success' => false]);
    }

    public function test_update_with_invalid_password(): void
    {
        $payload = $this->payload(['password' => '1234']);

        $response = $this->actingAs($this->admin)
            ->patch("/api/users/{$this->target->user_id}", $payload);

        $response->assertStatus(422)
            ->assertJson(['success' => false]);
    }

    public function test_update_with_password_not_confirmed(): void
    {
        $payload = $this->payload(['password' => 'password12345', 'password_confirmation' => 'password1234']);

        $response = $this->actingAs($this->admin)
            ->patch("/api/users/{$this->target->user_id}", $payload);

        $response->assertStatus(422)
            ->assertJson(['success' => false]);
    }

    public function test_update_with_invalid_role(): void
    {
        $payload = $this->payload(['role' => 'qweqwe']);

        $response = $this->actingAs($this->admin)
            ->patch("/api/users/{$this->target->user_id}", $payload);

        $response->assertStatus(422)
            ->assertJson(['success' => false]);
    }

    public function test_update_with_email(): void
    {
        $originalEmail = $this->target->email;
        $payload = $this->payload(['email' => 'newemail@example.com']);

        $response = $this->actingAs($this->admin)
            ->patch("/api/users/{$this->target->user_id}", $payload);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('users', [
            'user_id' => $this->target->user_id,
            'email'   => $originalEmail,
        ]);
    }
}
