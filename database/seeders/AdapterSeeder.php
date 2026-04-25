<?php

namespace Database\Seeders;

use App\Enums\AdapterName;
use App\Enums\AdapterType;
use App\Models\Adapter;
use App\Repositories\Contracts\AdapterRepositoryInterface;
use App\Services\Adapters\Telegram\Bot\TelegramBotAdapterService;
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
                'handler'         => TelegramBotAdapterService::class,
                'settings_schema' => [
                    'fields' => [
                        [
                            'name'     => 'bot_token',
                            'type'     => 'text',
                            'label'    => 'Токен бота',
                            'required' => true,
                        ],
                    ]
                ]
            ],
            [
                'adapter_name'    => AdapterName::WHATSAPP,
                'adapter_type'    => AdapterType::GREEN_API,
                'slug'            => $this->getSlug(AdapterName::WHATSAPP, AdapterType::GREEN_API),
                'handler'         => 'TEST',
                'settings_schema' => [
                    'fields' => [
                        [
                            'name'     => 'instance',
                            'type'     => 'text',
                            'label'    => 'Инстанс',
                            'required' => true,
                        ],
                        [
                            'name'     => 'secret',
                            'type'     => 'text',
                            'label'    => 'Инстанс токен',
                            'required' => true,
                        ],
                    ]
                ]
            ]
        ];

        foreach ($adapters as $adapter) {
            Adapter::updateOrCreate(['slug' => $adapter['slug']], $adapter);
        }

        $this->repository->forget();
    }

    protected function getSlug(AdapterName $name, AdapterType $type): string
    {
        return sprintf('%s:%s', $name->value, $type->value);
    }
}
