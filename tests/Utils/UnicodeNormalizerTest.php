<?php

use Junholee14\LaravelUnicodeNormalizer\Utils\UnicodeNormalizer;

it('should normalize unicode', function () {
    // given
    $value = normalizer_normalize('한글', Normalizer::FORM_D);
    $expected = normalizer_normalize('한글', config('unicode-normalizer.normalization_form', Normalizer::FORM_C));

    // when
    $result = UnicodeNormalizer::normalize($value);

    // then
    expect($result)->toBe($expected);
});
