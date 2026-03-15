<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Console\Exception\RuntimeException;

class MakeHandler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:handler {name?} {--handler} {--command}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Handler (Command + Handler)';

    protected array $createdClasses =  [];

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        try {
            $this->createdClasses = [];

            $input = $this->argument('name');

            if (!$input) {
                throw new RuntimeException('Name cannot be empty');
            }

            $parts = new Collection(explode('/', $input));
            $name = $parts->pop();

            $isCreateHandler = $this->option('handler');
            $isCreateCommand = $this->option('command');

            if (!$isCreateHandler && !$isCreateCommand) {
                $this->createCommand($parts, $name);
                $this->createHandler($parts, $name);
            }

            if ($isCreateHandler) {
                $this->createHandler($parts, $name);
            }

            if ($isCreateCommand) {
                $this->createCommand($parts, $name);
            }

            return self::SUCCESS;
        } catch (RuntimeException $e) {
            $this->error($e->getMessage());

            foreach ($this->createdClasses as $file) {
                File::delete($file);
            }

            return self::FAILURE;
        }
    }

    protected function createFile(Collection $path, string $name, string $dir, string $suffix, string $stub): void
    {
        $namespace = $path->implode('\\');
        $content = Str::replace(['{{ namespace }}', '{{ name }}'], [$namespace, $name], $stub);

        $fullPath = app_path(
            sprintf('%s/%s/%s%s.php',
                $dir,
                $path->implode(DIRECTORY_SEPARATOR),
                $name,
                $suffix
            )
        );

        if (File::exists($fullPath)) {
            throw new RuntimeException("File already exists: {$fullPath}");
        }

        File::ensureDirectoryExists(dirname($fullPath));
        if (!File::put($fullPath, $content)) {
            throw new RuntimeException("Unable to write file: {$fullPath}");
        }

        $this->createdClasses[] = $fullPath;
    }

    protected function createCommand(Collection $path, string $name): void
    {
        $this->createFile($path, $name, 'Commands', 'Command', $this->getCommandStub());
        $this->info("Created: Commands/{$name}Command.php");
    }

    protected function createHandler(Collection $path, string $name): void
    {
        $this->createFile($path, $name, 'Handlers', 'Handler', $this->getHandlerStub());
        $this->info("Created: Handlers/{$name}Handler.php");
    }

    protected function getCommandStub(): string
    {
        return File::get(base_path('stubs/command.stub'));
    }

    protected function getHandlerStub(): string
    {
        return File::get(base_path('stubs/handler.stub'));
    }
}
