<?php

namespace Database\Seeders;

use App\Enums\AdapterName;
use App\Enums\AdapterType;
use App\Models\Adapter;
use App\Repositories\Contracts\AdapterRepositoryInterface;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdapterSeeder extends Seeder
{
    public function __construct(
        private readonly AdapterRepositoryInterface $repository
    ) {}

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adapters = [
            // TELEGRAM BOT
            [
                'adapter_name'    => AdapterName::TELEGRAM,
                'adapter_type'    => AdapterType::BOT,
                'slug'            => $this->getSlug(AdapterName::TELEGRAM, AdapterType::BOT),
                'handler'         => 'TEST',
                'settings_schema' => [
                    'fields' => [
                        [
                            'name'     => 'bot_token',
                            'type'     => 'text',
                            'label'    => 'Токен бота',
                            'required' => true,
                            'rules'    => ['required', 'string', 'min:10'],
                        ],
                    ]
                ]
            ]
        ];

        foreach ($adapters as $adapter) {
            Adapter::firstOrCreate(['slug' => $adapter['slug']], $adapter);
        }

        $this->repository->forget();
    }

    protected function getSlug(AdapterName $name, AdapterType $type): string
    {
        return sprintf('%s:%s', $name->value, $type->value);
    }
}
