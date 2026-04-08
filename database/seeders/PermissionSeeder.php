<?php

namespace Database\Seeders;

use App\Enums\PermissionSlug;
use App\Models\Permission;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function __construct(
        private readonly PermissionRepositoryInterface $repository,
    ) {}

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'slug'        => PermissionSlug::USERS_MANAGE,
                'label'       => 'Управление пользователями',
                'description' => 'Разрешить пользователю управлять другими пользователями'
            ],
            [
                'slug'        => PermissionSlug::CHANNELS_MANAGE,
                'label'       => 'Управление каналами',
                'description' => 'Разрешить пользователю управлять каналами компании'
            ]
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['slug' => $permission['slug']], $permission);
        }

        $this->repository->forget();
    }
}
