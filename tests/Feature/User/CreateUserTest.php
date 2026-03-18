<?php

namespace Tests\Feature\User;

use App\Enums\Role;
use App\Events\UserCreated;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
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

    private function payload(array $overrides = []): array
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
        $payload = $this->payload();

        $response = $this->actingAs($this->admin)
            ->postJson('/api/users', $payload);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    public function test_create_user_with_empty_avatar(): void
    {
        $payload = $this->payload(['avatar' => null]);

        $response = $this->actingAs($this->admin)
            ->postJson('/api/users', $payload);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    public function test_user_cannot_create_user(): void
    {
        $payload = $this->payload();

        $response = $this->actingAs($this->user)
            ->postJson('/api/users', $payload);

        $response->assertStatus(403)
            ->assertJson(['success' => false]);

    }

    public function test_unauthenticated_user_gets_401(): void
    {
        $payload = $this->payload();

        $response = $this->postJson('/api/users', $payload);

        $response->assertStatus(401)
            ->assertJson(['success' => false]);

    }

    public function test_create_user_with_invalid_email(): void
    {
        $payload = $this->payload(['email' => 'test']);

        $response = $this->actingAs($this->admin)
            ->postJson('/api/users', $payload);

        $response->assertStatus(422)
            ->assertJson(['success' => false]);
    }

    public function test_create_user_with_duplicate_email(): void
    {
        $payload = $this->payload();
        User::factory()->create(['email' => $payload['email']]);

        $response = $this->actingAs($this->admin)
            ->postJson('/api/users', $payload);

        $response->assertStatus(422)
            ->assertJson(['success' => false]);
    }

    public function test_create_user_with_invalid_password(): void
    {
        $payload = $this->payload(['password' => '1234', 'password_confirmation' => '1234']);

        $response = $this->actingAs($this->admin)
            ->postJson('/api/users', $payload);

        $response->assertStatus(422)
            ->assertJson(['success' => false]);
    }

    public function test_create_user_with_password_not_confirmed(): void
    {
        $payload = $this->payload(['password' => 'password12345', 'password_confirmation' => 'password123456']);

        $response = $this->actingAs($this->admin)
            ->postJson('/api/users', $payload);

        $response->assertStatus(422)
            ->assertJson(['success' => false]);
    }

    public function test_user_created_event_is_dispatched(): void
    {
        Event::fake();

        $payload = $this->payload();

        $this->actingAs($this->admin)
            ->postJson('/api/users', $payload);

        Event::assertDispatched(UserCreated::class, function ($event) use ($payload) {
            return $event->user->email === $payload['email'];
        });
    }
}
