<?php

namespace Tests\Feature\User;

use App\Enums\PermissionSlug;
use App\Models\Company;
use App\Models\Permission;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
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
        $this->seed(PermissionSeeder::class);
        $permission = Permission::where('slug', PermissionSlug::USERS_MANAGE)->first();

        $this->admin = User::factory()->create();
        $this->admin->permissions()->sync([$permission->permission_id]);

        $this->user = User::factory()->create();
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

    public function test_admin_can_search_users(): void
    {
        $company = $this->admin->company;
        $target = User::factory()->for($company)->create(['username' => 'uniquesearchname']);
        User::factory()->for($company)->create(['username' => 'otherusername']);

        $response = $this->actingAs($this->admin)
            ->withHeaders(['Referer' => config('app.url')])
            ->getJson('/api/users?search=uniquesearchname');

        $ids = collect($response->json('data.data'))->pluck('user_id');

        $response->assertStatus(200);
        $this->assertContains($target->user_id, $ids);
    }

    public function test_search_validates_max_length(): void
    {
        $response = $this->actingAs($this->admin)
            ->withHeaders(['Referer' => config('app.url')])
            ->getJson('/api/users?search=' . str_repeat('a', 256));

        $response->assertStatus(422);
    }

    public function test_invalid_sort_field_returns_422(): void
    {
        $response = $this->actingAs($this->admin)
            ->withHeaders(['Referer' => config('app.url')])
            ->getJson('/api/users?sort_field=invalid');

        $response->assertStatus(422);
    }

    public function test_admin_can_sort_users_by_username(): void
    {
        $company = $this->admin->company;
        User::factory()->for($company)->create(['username' => 'beta']);
        User::factory()->for($company)->create(['username' => 'alpha']);

        $response = $this->actingAs($this->admin)
            ->withHeaders(['Referer' => config('app.url')])
            ->getJson('/api/users?sort_field=username&sort_order=asc');

        $usernames = collect($response->json('data.data'))->pluck('username')->values();

        $response->assertStatus(200);
        $this->assertEquals($usernames->sort()->values(), $usernames);
    }

    public function test_invalid_sort_order_returns_422(): void
    {
        $response = $this->actingAs($this->admin)
            ->withHeaders(['Referer' => config('app.url')])
            ->getJson('/api/users?sort_order=invalid');

        $response->assertStatus(422);
    }

    public function test_pagination_meta_is_present(): void
    {
        $response = $this->actingAs($this->admin)
            ->withHeaders(['Referer' => config('app.url')])
            ->getJson('/api/users');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'meta' => ['total', 'per_page', 'current_page', 'last_page']
                ]
            ]);
    }

    public function test_deleted_user_not_visible_in_list(): void
    {
        $company = $this->admin->company;
        $deletedUser = User::factory()->for($company)->create();
        $deletedUser->delete();

        $response = $this->actingAs($this->admin)
            ->withHeaders(['Referer' => config('app.url')])
            ->getJson('/api/users');

        $ids = collect($response->json('data.data'))->pluck('user_id');
        $this->assertNotContains($deletedUser->user_id, $ids);
    }
}
