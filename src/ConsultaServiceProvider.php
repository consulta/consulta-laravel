<?php

namespace Consulta\Laravel;

use Illuminate\Support\ServiceProvider;

/**
 * Class ConsultaServiceProvider
 * @package Consulta\Laravel
 */
class ConsultaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Consulta::class, function () {
            return new Consulta();
        });

        $this->app->alias(Consulta::class, 'consulta');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
