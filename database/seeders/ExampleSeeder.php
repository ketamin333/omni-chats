<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ExampleSeeder extends Seeder
{
    use WithoutModelEvents;

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

        User::factory()->count(100)->for($company)->create();
    }
}
