<?php

declare(strict_types=1);

namespace Guava\Sequence;

use Illuminate\Support\ServiceProvider;

class SequenceServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @codeCoverageIgnore
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'migrations');
    }
}
