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
        $company = Company::create([
            'company_name' => 'Test Company',
            'api_key' => bin2hex(random_bytes(32)),
        ]);

        User::factory(10)->create([
            'company_id' => $company->company_id,
        ]);

        User::create([
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('79205052731'),
            'company_id' => $company->company_id,
            'avatar' => null,
            'phone' => '79205052731',
        ]);
    }
}
