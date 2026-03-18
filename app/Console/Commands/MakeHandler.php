<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Console\Exception\RuntimeException;
use Throwable;
use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\text;

class MakeHandler extends Command
{
    protected $signature = 'make:handler {name? : Handler name e.g. User/CreateUser}
                                         {--command : Generate a Command DTO}
                                         {--query : Generate a Query DTO}';

    protected $description = 'Create a new Handler (Command/Query + Handler)';

    protected array $createdFiles = [];

    public function handle(): int
    {
        try {
            $name = $this->argument('name');
            $withCommand = $this->option('command');
            $withQuery = $this->option('query');
            $isInteractive = !$this->argument('name');

            if (!$name) {
                $name = text(
                    label: 'What should the handler be named?',
                    placeholder: 'User/CreateUser',
                    required: true,
                );
            }

            if ($isInteractive && !$withCommand && !$withQuery) {
                $options = multiselect(
                    label: 'What to generate?',
                    options: ['Command', 'Query'],
                    default: ['Command']
                );

                $withCommand = in_array('Command', $options);
                $withQuery = in_array('Query', $options);
            }

            $parts = collect(explode('/', $name));
            $baseName = Str::replaceLast('Handler', '', $parts->pop());

            $this->generate('Handlers', $parts, $baseName, 'Handler', $this->getStub('handler'));

            if ($withCommand) {
                $this->generate('Commands', $parts, $baseName, 'Command', $this->getStub('command'));
            }

            if ($withQuery) {
                $this->generate('Queries', $parts, $baseName, 'Query', $this->getStub('query'));
            }

            $this->components->info('All files generated successfully.');

            return self::SUCCESS;
        } catch (Throwable $e) {
            $this->rollback();
            $this->components->error($e->getMessage());

            return self::FAILURE;
        }
    }

    protected function generate(string $dir, Collection $path, string $name, string $suffix, string $stub): void
    {
        $subPath = $path->isEmpty() ? '' : $path->implode('/') . '/';
        $namespace = 'App\\' . $dir . ($path->isEmpty() ? '' : '\\' . $path->implode('\\'));

        $fileName = "{$name}{$suffix}.php";
        $fullPath = app_path("{$dir}/{$subPath}{$fileName}");

        if (File::exists($fullPath)) {
            throw new RuntimeException("File already exists: {$fullPath}");
        }

        $content = str_replace(
            ['{{ namespace }}', '{{ name }}'],
            [$namespace, $name],
            $stub
        );

        File::ensureDirectoryExists(dirname($fullPath));
        File::put($fullPath, $content);

        $this->createdFiles[] = $fullPath;
        $this->components->task("Creating {$dir}/{$subPath}{$fileName}");
    }

    protected function getStub(string $type): string
    {
        $path = base_path("stubs/{$type}.stub");
        if (!File::exists($path)) {
            throw new RuntimeException("Stub not found: {$path}");
        }
        return File::get($path);
    }

    protected function rollback(): void
    {
        foreach ($this->createdFiles as $file) {
            File::delete($file);
        }
    }
}
