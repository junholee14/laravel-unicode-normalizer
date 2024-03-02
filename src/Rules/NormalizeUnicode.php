<?php

namespace Junholee14\LaravelUnicodeNormalizer\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use Normalizer;

class NormalizeUnicode implements ValidationRule
{
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        if (is_string($value) && !empty($value)) {
            $normalizationForm = config('unicode-normalizer.form', Normalizer::FORM_C);
            if (!Normalizer::isNormalized($value, $normalizationForm)) {
                $fail('validation.normalize_unicode')->translate(['attribute' => $attribute]);
            }
        }
    }
}
