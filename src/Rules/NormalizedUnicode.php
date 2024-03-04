<?php

namespace Junholee14\LaravelUnicodeNormalizer\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use Normalizer;

class NormalizedUnicode implements ValidationRule
{
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        if (is_string($value) && !empty($value)) {
            $normalizationForm = config('unicode-normalizer.normalization_form', Normalizer::FORM_C);
            if (!Normalizer::isNormalized($value, $normalizationForm)) {
                $fail(
                    __('laravelUnicodeNormalizer::validation.normalize_unicode')
                );
            }
        }
    }
}
