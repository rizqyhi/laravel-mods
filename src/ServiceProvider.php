<?php

namespace Rizqyhi\LaravelMods;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands(
            'Rizqyhi\LaravelMods\Commands\MakeModuleCommand',
            'Rizqyhi\LaravelMods\Commands\MakeControllerCommand',
            'Rizqyhi\LaravelMods\Commands\MakeViewsCommand',
            'Rizqyhi\LaravelMods\Commands\MakeLangAssetCommand'
        );
    }
}
