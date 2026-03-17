<?php

namespace Tests\Feature\User;

use App\Enums\Role;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $user;
    protected UploadedFile $file;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);

        Storage::fake('public');
        $this->file = UploadedFile::fake()->image('avatar.jpg');

        $this->admin = User::factory()->create();
        $this->admin->assignRole(Role::ADMIN);

        $this->user = User::factory()->create();
        $this->user->assignRole(Role::USER);
    }

    private function data(array $overrides = []): array
    {
        return array_merge([
            'username' => 'John',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => Role::USER->value,
            'avatar' => $this->file,
        ], $overrides);
    }

    public function test_admin_can_create_user(): void
    {
        $data = $this->data();

        $response = $this->actingAs($this->admin)
            ->postJson('/api/users', $data);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    public function test_create_user_with_empty_avatar(): void
    {
        $data = $this->data(['avatar' => null]);

        $response = $this->actingAs($this->admin)
            ->postJson('/api/users', $data);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    public function test_user_cannot_create_user(): void
    {
        $data = $this->data();

        $response = $this->actingAs($this->user)
            ->postJson('/api/users', $data);

        $response->assertStatus(403)
            ->assertJson(['success' => false]);

    }

    public function test_unauthenticated_user_gets_401(): void
    {
        $data = $this->data();

        $response = $this->postJson('/api/users', $data);

        $response->assertStatus(401)
            ->assertJson(['success' => false]);

    }

    public function test_create_user_with_invalid_email(): void
    {
        $data = $this->data(['email' => 'test']);

        $response = $this->actingAs($this->admin)
            ->postJson('/api/users', $data);

        $response->assertStatus(422)
            ->assertJson(['success' => false]);
    }

    public function test_create_user_with_duplicate_email(): void
    {
        $data = $this->data();
        User::factory()->create(['email' => $data['email']]);

        $response = $this->actingAs($this->admin)
            ->postJson('/api/users', $data);

        $response->assertStatus(422)
            ->assertJson(['success' => false]);
    }

    public function test_create_user_with_invalid_password(): void
    {
        $data = $this->data(['password' => '1234', 'password_confirmation' => '1234']);

        $response = $this->actingAs($this->admin)
            ->postJson('/api/users', $data);

        $response->assertStatus(422)
            ->assertJson(['success' => false]);
    }

    public function test_create_user_with_password_not_confirmed(): void
    {
        $data = $this->data(['password' => 'password12345', 'password_confirmation' => 'password123456']);

        $response = $this->actingAs($this->admin)
            ->postJson('/api/users', $data);

        $response->assertStatus(422)
            ->assertJson(['success' => false]);
    }
}
