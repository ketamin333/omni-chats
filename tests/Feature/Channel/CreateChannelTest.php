<?php

namespace Tests\Feature\Channel;

use App\Enums\Role;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateChannelTest extends TestCase
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
            'channel_name' => 'bot 1',
            'type' => 'telegram:bot',
            'credentials' => [
                'bot_token' => 'token'
            ],
        ], $overrides);
    }

    public function test_admin_can_create_channel(): void
    {
        $payload = $this->payload();

        $response = $this->actingAs($this->admin)
            ->postJson('/api/channels', $payload);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }
}
