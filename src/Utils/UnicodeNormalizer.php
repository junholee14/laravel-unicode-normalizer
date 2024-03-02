<?php

namespace Junholee14\LaravelUnicodeNormalizer\Utils;

use Symfony\Polyfill\Intl\Normalizer\Normalizer;

final class UnicodeNormalizer
{
    public static function normalize(string $value): string
    {
        $normalizationForm = config('unicode-normalizer.normalization_form', Normalizer::FORM_C);
        return Normalizer::normalize($value, $normalizationForm);
    }
}
