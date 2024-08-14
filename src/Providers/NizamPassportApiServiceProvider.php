<?php

namespace Nizam\PassportApi\Providers;

use Illuminate\Support\ServiceProvider;
use Nizam\PassportApi\Console\Commands\InstallPassportApi;

class NizamPassportApiServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallPassportApi::class,
            ]);
        }
    }

    public function register() {}
}
