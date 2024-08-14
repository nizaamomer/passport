<?php

namespace Nizam\PassportApi\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class InstallPassportApi extends Command
{
    protected $signature = 'nizam:install-passport-api';
    protected $description = 'Install the Passport API with Nizam Passport API scaffolding.';

    public function handle()
    {
        $this->info(' -Checking Laravel Passport installation...');

        if (!$this->passportInstalled()) {
            $this->warn('Laravel Passport is not installed. Please run "php artisan install:api --passport" first.');

            if (!$this->confirm('Do you want to run this command now?', true)) {
                $this->error('You cannot install the Nizam package without Laravel Passport. Installation aborted.');
                return 1;
            }

            $this->call('install:api', ['--passport' => true]);

            if (!$this->passportInstalled()) {
                $this->error('Laravel Passport installation failed. Installation of the Nizam package cannot continue.');
                return 1;
            }
        }

        $this->info(' -Laravel Passport is installed.');
        $this->info('- Proceeding with Nizam Passport API scaffolding installation...');


        $this->installPassportApiScaffolding();
        $this->displaySpinner('Adding Auth scaffolding...');

        $this->displaySpinner('Updating Auth configuration...');
        $this->updateAuthConfig();

        $this->displaySpinner('Appending Auth Routes...');
        $this->appendAuthRoutesToWeb();

        $this->displaySpinner('Adding HasApiTokens trait to User model...');
        $this->addHasApiTokensToUserModel();

        $this->displaySpinner('Updating API Routes...');
        $this->updateApiRoutes();

        $this->displaySpinner('Removing unnecessary scaffolding...');
        $this->removeScaffoldingUnnecessaryForApis();

        $this->info(' - Nizam Passport API scaffolding installed successfully.');
    }

    protected function passportInstalled()
    {
        return file_exists(config_path('passport.php'));
    }

    protected function displaySpinner($message)
    {
        $spinner = ['|', '/', '-', '\\'];
        $this->getOutput()->write("\033[0G$message ");

        for ($i = 0; $i < 10; $i++) {
            foreach ($spinner as $char) {
                $this->getOutput()->write("\033[0G$message $char");
                usleep(25000);
            }
        }
        $this->getOutput()->write("\033[0G$message Done!\n");
    }

    protected function installPassportApiScaffolding()
    {
        $files = new Filesystem;

        // Controllers...
        $this->displaySpinner('Adding Controllers...');
        $files->ensureDirectoryExists(app_path('Http/Controllers/Auth'));
        $files->copyDirectory(__DIR__ . '/../../Http/Controllers/Auth', app_path('Http/Controllers/Auth'));
        $files->ensureDirectoryExists(app_path('Http/Controllers/Api'));
        $files->copyDirectory(__DIR__ . '/../../Http/Controllers/Api', app_path('Http/Controllers/Api'));

        // Requests...
        $this->displaySpinner('Adding Requests...');
        $files->ensureDirectoryExists(app_path('Http/Requests/Auth'));
        $files->copyDirectory(__DIR__ . '/../../Http/Requests/Auth', app_path('Http/Requests/Auth'));

        // Routes...
        $this->displaySpinner('Appending Routes...');
        $files->append(base_path('routes/auth.php'), file_get_contents(__DIR__ . '/../../routes/auth.php'));
        $files->append(base_path('routes/api.php'), file_get_contents(__DIR__ . '/../../routes/api.php'));

        // Environment...
        $this->displaySpinner('Updating Environment...');
        if (!$files->exists(base_path('.env'))) {
            copy(base_path('.env.example'), base_path('.env'));
        }

        file_put_contents(
            base_path('.env'),
            preg_replace('/APP_URL=(.*)/', 'APP_URL=http://localhost:8000' . PHP_EOL . 'FRONTEND_URL=http://localhost:3000', file_get_contents(base_path('.env')))
        );
    }

    protected function updateAuthConfig()
    {
        $authConfigPath = config_path('auth.php');

        $authConfig = file_get_contents($authConfigPath);

        if (strpos($authConfig, "'api' => [") === false) {
            $search = "'guards' => [\n        'web' => [\n            'driver' => 'session',\n            'provider' => 'users',\n        ],";
            $replace = "'guards' => [\n        'web' => [\n            'driver' => 'session',\n            'provider' => 'users',\n        ],\n\n        'api' => [\n            'driver' => 'passport',\n            'provider' => 'users',\n        ],";

            $authConfig = str_replace($search, $replace, $authConfig);

            file_put_contents($authConfigPath, $authConfig);
        }
    }

    protected function appendAuthRoutesToWeb()
    {
        $files = new Filesystem;

        // Path to the source file in your package
        $sourcePath = __DIR__ . '/../../routes/web.php';

        // Path to the destination file in the Laravel application
        $destinationPath = base_path('routes/web.php');

        // Check if the source file exists
        if ($files->exists($sourcePath)) {
            // Replace the existing routes/web.php file
            $files->copy($sourcePath, $destinationPath);
            // $this->info('The routes/web.php file has been replaced successfully.');
        } else {
            // $this->error('The source file does not exist.');
        }
    }

    protected function addHasApiTokensToUserModel()
    {
        $userModelPath = app_path('Models/User.php');
        $files = new Filesystem;

        if ($files->exists($userModelPath)) {
            $userModelContent = $files->get($userModelPath);

            if (strpos($userModelContent, 'HasApiTokens') === false) {
                if (strpos($userModelContent, 'use Illuminate\Foundation\Auth\User as Authenticatable;') !== false) {
                    $userModelContent = preg_replace(
                        '/use Illuminate\\\\Foundation\\\\Auth\\\\User as Authenticatable;/',
                        'use Illuminate\\Foundation\\Auth\\User as Authenticatable;' . PHP_EOL . 'use Laravel\\Passport\\HasApiTokens;',
                        $userModelContent
                    );
                }

                if (strpos($userModelContent, 'use HasFactory, Notifiable;') !== false) {
                    $userModelContent = preg_replace(
                        '/use HasFactory, Notifiable;/',
                        'use HasApiTokens, HasFactory, Notifiable;',
                        $userModelContent
                    );
                } else {
                    $userModelContent = preg_replace(
                        '/use Illuminate\\Foundation\\Auth\\User as Authenticatable;/',
                        'use Laravel\\Passport\\HasApiTokens;' . PHP_EOL . 'use Illuminate\\Foundation\\Auth\\User as Authenticatable;' . PHP_EOL . 'use HasApiTokens, HasFactory, Notifiable;',
                        $userModelContent
                    );
                }

                $files->put($userModelPath, $userModelContent);
            }
        } else {
            $this->error('User model not found.');
        }
    }

    protected function updateApiRoutes()
    {
        $apiRoutesPath = base_path('routes/api.php');
        $files = new Filesystem;

        if ($files->exists($apiRoutesPath)) {
            $newApiRoutes = <<<PHP
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GetAuthUserController;

Route::middleware(['auth:api'])->group(function () {
    Route::get('user', GetAuthUserController::class);
});

require __DIR__ . '/auth.php';

PHP;

            $files->put($apiRoutesPath, $newApiRoutes);

            // $this->info('API routes have been updated.');
        } else {
            $this->error('api.php file not found.');
        }
    }

    protected function removeScaffoldingUnnecessaryForApis()
    {
        $files = new Filesystem;

        $files->delete(base_path('package.json'));
        $files->delete(base_path('vite.config.js'));

        $files->delete(resource_path('views/welcome.blade.php'));
        $files->put(resource_path('views/.gitkeep'), PHP_EOL);

        $files->deleteDirectory(resource_path('css'));
        $files->deleteDirectory(resource_path('js'));
    }
}