<?php

namespace Tests\Feature\Console;

use Illuminate\Filesystem\Filesystem;
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
    }

    public function test_creates_files_without_root_folder(): void
    {
        $name = 'Auth/Login';

        $this->artisan('make:handler', ['name' => $name]);

        $this->assertFileExists(app_path('Commands/Auth/LoginCommand.php'));
        $this->assertFileExists(app_path('Handlers/Auth/LoginHandler.php'));
    }

    public function test_creates_files_without_subfolder(): void
    {
        $name = 'Login';

        $this->artisan('make:handler', ['name' => $name]);

        $this->assertFileExists(app_path('Commands/LoginCommand.php'));
        $this->assertFileExists(app_path('Handlers/LoginHandler.php'));
    }

    public function test_fails_when_name_is_empty(): void
    {
        $output = $this->artisan('make:handler');

        $output->assertExitCode(CommandAlias::FAILURE);
    }

    public function test_creates_command_and_handler_files(): void
    {
        $name = 'Auth/Login';

        $this->artisan('make:handler', ['name' => $name]);

        $this->assertFileExists(app_path('Commands/Auth/LoginCommand.php'));
        $this->assertFileExists(app_path('Handlers/Auth/LoginHandler.php'));
    }

    public function test_creates_only_handler_with_flag(): void
    {
        $name = 'Auth/Login';

        $this->artisan('make:handler', ['name' => $name, '--handler' => true]);

        $this->assertFileDoesNotExist(app_path('Commands/Auth/LoginCommand.php'));
        $this->assertFileExists(app_path('Handlers/Auth/LoginHandler.php'));
    }

    public function test_creates_only_command_with_flag(): void
    {
        $name = 'Auth/Login';

        $this->artisan('make:handler', ['name' => $name, '--command' => true]);

        $this->assertFileDoesNotExist(app_path('Handlers/Auth/LoginHandler.php'));
        $this->assertFileExists(app_path('Commands/Auth/LoginCommand.php'));
    }

    public function test_rolls_back_command_if_handler_exists(): void
    {
        $name = 'Auth/Login';
        $this->artisan('make:handler', ['name' => $name]);

        $this->artisan('make:handler', ['name' => $name]);

        $this->assertFileExists(app_path('Handlers/Auth/LoginHandler.php'));
        $this->assertFileExists(app_path('Commands/Auth/LoginCommand.php'));
    }

    public function test_created_command_file_has_correct_class_name(): void
    {
        $name = 'Auth/Login';

        $this->artisan('make:handler', ['name' => $name]);

        $this->assertStringContainsString(
            "class LoginCommand",
            file_get_contents(app_path('Commands/Auth/LoginCommand.php'))
        );
    }

    public function test_created_command_file_has_correct_namespace(): void
    {
        $name = 'Auth/Login';
        $this->artisan('make:handler', ['name' => $name]);

        $this->assertStringContainsString(
            "namespace App\Commands\Auth;",
            file_get_contents(app_path('Commands/Auth/LoginCommand.php'))
        );
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        (new Filesystem())->deleteDirectory($this->tempPath);
    }
}
