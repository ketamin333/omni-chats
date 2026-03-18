<?php

namespace Tests\Feature\Console;

use Illuminate\Filesystem\Filesystem;
use Laravel\Prompts\Prompt;
use Symfony\Component\Console\Command\Command as CommandAlias;
use Tests\TestCase;

class MakeHandlerTest extends TestCase
{
    protected string $tempPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tempPath = sys_get_temp_dir() . '/test-make-handler';
        $this->app->useAppPath($this->tempPath);

        Prompt::fallbackWhen(true);
    }

    public function test_create_only_handler_via_parameters(): void
    {
        $this->artisan('make:handler', ['name' => 'Auth/Test'])
            ->assertExitCode(CommandAlias::SUCCESS);

        $this->assertFileExists(app_path('Handlers/Auth/TestHandler.php'));
        $this->assertFileDoesNotExist(app_path('Commands/Auth/TestCommand.php'));
        $this->assertFileDoesNotExist(app_path('Queries/Auth/TestQuery.php'));
    }

    public function test_create_handler_with_command_via_parameters(): void
    {
        $this->artisan('make:handler', ['name' => 'Auth/Test', '--command' => true])
            ->assertExitCode(CommandAlias::SUCCESS);

        $this->assertFileExists(app_path('Handlers/Auth/TestHandler.php'));
        $this->assertFileExists(app_path('Commands/Auth/TestCommand.php'));
        $this->assertFileDoesNotExist(app_path('Queries/Auth/TestQuery.php'));
    }

    public function test_create_handler_with_query_via_parameters(): void
    {
        $this->artisan('make:handler', ['name' => 'Auth/Test', '--query' => true])
            ->assertExitCode(CommandAlias::SUCCESS);

        $this->assertFileExists(app_path('Handlers/Auth/TestHandler.php'));
        $this->assertFileDoesNotExist(app_path('Commands/Auth/TestCommand.php'));
        $this->assertFileExists(app_path('Queries/Auth/TestQuery.php'));
    }

    public function test_create_handler_with_command_and_query_via_parameters(): void
    {
        $this->artisan('make:handler', ['name' => 'Auth/Test', '--command' => true, '--query' => true])
            ->assertExitCode(CommandAlias::SUCCESS);

        $this->assertFileExists(app_path('Handlers/Auth/TestHandler.php'));
        $this->assertFileExists(app_path('Commands/Auth/TestCommand.php'));
        $this->assertFileExists(app_path('Queries/Auth/TestQuery.php'));
    }

    public function test_rolls_back_on_failure(): void
    {
        (new Filesystem())->ensureDirectoryExists(app_path('Handlers/Auth'));
        file_put_contents(app_path('Handlers/Auth/TestHandler.php'), '<?php');

        $this->artisan('make:handler', ['name' => 'Auth/Test', '--command' => true])
            ->assertExitCode(CommandAlias::FAILURE);

        $this->assertFileDoesNotExist(app_path('Commands/Auth/TestCommand.php'));
    }

    public function test_correct_namespace_in_generated_file(): void
    {
        $this->artisan('make:handler', ['name' => 'Billing/Invoice/Create', '--command' => true])
            ->assertExitCode(CommandAlias::SUCCESS);

        $content = file_get_contents(app_path('Commands/Billing/Invoice/CreateCommand.php'));
        $this->assertStringContainsString('namespace App\Commands\Billing\Invoice;', $content);
        $this->assertStringContainsString('readonly class CreateCommand', $content);
    }

    public function test_works_without_subfolder(): void
    {
        $this->artisan('make:handler', ['name' => 'Login', '--command' => true])
            ->assertExitCode(CommandAlias::SUCCESS);

        $this->assertFileExists(app_path('Handlers/LoginHandler.php'));
        $this->assertFileExists(app_path('Commands/LoginCommand.php'));
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        (new Filesystem())->deleteDirectory($this->tempPath);
    }
}
