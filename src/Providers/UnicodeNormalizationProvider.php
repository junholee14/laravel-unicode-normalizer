<?php

namespace Junholee14\LaravelUnicodeNormalizer\Providers;

use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;

final class UnicodeNormalizationProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                    __DIR__ . '/../resources/lang' => resource_path('lang/vendor/laravelUnicodeNormalizer')
                ], 'lang');
            $this->publishes([
                __DIR__ . '/../config/unicode-normalizer.php' => config_path('unicode-normalization.php')
            ], 'config');
        }

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'laravelUnicodeNormalizer');
        $this->mergeConfigFrom(__DIR__ . '/../config/unicode-normalizer.php', 'unicode-normalizer');
    }
}
