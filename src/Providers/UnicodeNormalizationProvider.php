<?php

namespace Junholee14\LaravelUnicodeNormalizer\Providers;

use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;

final class UnicodeNormalizationProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/unicode_normalizer.php', 'unicode_normalizer');
        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([
                    __DIR__ . '/../config/unicode_normalizer.php' => config_path('unicode_normalization.php')
                ], 'config');
        }
    }
}
