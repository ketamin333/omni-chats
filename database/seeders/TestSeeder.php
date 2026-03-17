<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'username' => 'Фомин Александр',
            'email'    => 'afomin@gmail.com',
            'password' => Hash::make('password12345'),
        ]);

        $user->assignRole(Role::ADMIN);
    }
}
