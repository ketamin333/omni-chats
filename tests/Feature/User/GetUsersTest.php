<?php

namespace Tests\Feature\User;

use App\Enums\Role;
use App\Models\Company;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetUsersTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);

        $this->admin = User::factory()->create();
        $this->admin->assignRole(Role::ADMIN);

        $this->user = User::factory()->create();
        $this->user->assignRole(Role::USER);
    }

    public function test_admin_can_get_users(): void
    {
        $response = $this->actingAs($this->admin)
            ->withHeaders(['Referer' => config('app.url')])
            ->get('/api/users');

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    public function test_admin_cannot_see_users_from_another_company(): void
    {
        $company = $this->admin->company;
        $otherCompany = Company::factory()->create();

        $userSameCompany = User::factory()->for($company)->create();
        $userOtherCompany = User::factory()->for($otherCompany)->create();

        $response = $this->actingAs($this->admin)
            ->withHeaders(['Referer' => config('app.url')])
            ->getJson('/api/users');

        $ids = collect($response->json('data.data'))->pluck('user_id');

        $this->assertContains($userSameCompany->user_id, $ids);
        $this->assertNotContains($userOtherCompany->user_id, $ids);
        $response->assertStatus(200);
    }

    public function test_user_cannot_get_users(): void
    {
        $response = $this->actingAs($this->user)
            ->withHeaders(['Referer' => config('app.url')])
            ->get('/api/users');

        $response->assertStatus(403)
            ->assertJson(['success' => false]);
    }

    public function test_unauthenticated_user_gets_401(): void
    {
        $response = $this->postJson('/api/users');

        $response->assertStatus(401)
            ->assertJson(['success' => false]);
    }
}
