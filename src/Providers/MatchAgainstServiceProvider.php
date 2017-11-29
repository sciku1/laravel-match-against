<?php

namespace Sciku1\LaravelMatchAgainst\Providers;

use Illuminate\Support\ServiceProvider;

class MatchAgainstServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        foreach (glob(__DIR__ . '../Macros/*') as $path) {
            require_once $path;
        }

    }
}
