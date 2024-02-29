<?php

namespace Junholee14\LaravelUnicodeNormalizer\Tests;

use Junholee14\LaravelUnicodeNormalizer\Providers\UnicodeNormalizationProvider;
use Orchestra\Testbench\TestCase;

class PackageTestCase extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            UnicodeNormalizationProvider::class
        ];
    }
}
