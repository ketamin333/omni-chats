<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ExampleSeeder extends Seeder
{
    use WithoutModelEvents;

    public function __construct(
        protected PermissionRepositoryInterface $permissionRepository,
    ) {}

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company = Company::factory()->create();

        $user = User::factory()->for($company)->create([
            'username' => 'ketamin333',
            'email'    => 'fomin.casch@yandex.ru',
            'password' => Hash::make('password12345'),
        ]);

        $user->permissions()->sync(
            $this->permissionRepository->getAll()->pluck('permission_id')
        );

        User::factory()->count(100)->for($company)->create();
    }
}
