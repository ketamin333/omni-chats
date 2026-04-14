<?php

namespace App\Services\Adapters\Telegram\Bot;

use App\Exceptions\Adapters\Telegram\TelegramBotApiException;
use App\Models\Channel;
use App\Services\Adapters\Telegram\Bot\Client\TelegramBotClientFactory;
use App\Services\Adapters\Telegram\Bot\Client\TelegramBotClientInterface;
use App\Services\Adapters\Telegram\Bot\DTO\Contracts\TelegramBotFileInterface;
use App\Services\Adapters\Telegram\Bot\DTO\Contracts\TelegramBotNamedFileInterface;
use App\Services\Storage\DTO\StoredFile;
use App\Services\Storage\StoragePathGenerator;
use finfo;
use Illuminate\Support\Facades\Storage;

class TelegramBotFileService
{
    public function __construct(
        private TelegramBotClientFactory $factory,
        private StoragePathGenerator $generator,
    ) {}

    public function store(Channel $channel, TelegramBotFileInterface $file): StoredFile
    {
        try {
            $client = $this->getClient($channel->credentials['bot_token']);

            $fileInfo = $client->getFile($file->fileId());
            $fileContent = $client->downloadFile($fileInfo['result']['file_path']);

            $fInfo = new finfo(FILEINFO_MIME_TYPE);
            $mimeType = $fInfo->buffer($fileContent);
            $ext = pathinfo($fileInfo['result']['file_path'], PATHINFO_EXTENSION);

            $path = $this->generator->generate("chats/{$channel->channel_id}", $ext);
            $disk = config('filesystems.default');

            Storage::disk($disk)->put($path, $fileContent);

            $originalName = $file instanceof TelegramBotNamedFileInterface
                ? $file->fileName()
                : basename($fileInfo['result']['file_path']);

            return new StoredFile(
                originalName: $originalName,
                disk: $disk,
                path: $path,
                mimeType: $mimeType,
                size: $file->fileSize(),
            );
        } catch (TelegramBotApiException $e) {
            throw $e;
        }
    }

    protected function getClient(string $botToken): TelegramBotClientInterface
    {
        return $this->factory->make($botToken);
    }
}
