<?php

use Illuminate\Http\Request;
use Junholee14\LaravelUnicodeNormalizer\Rules\NormalizedUnicode;

test('valid configured normalization form passes', function () {
    // given
    $normalizationForm = config('unicode-normalizer.form', Normalizer::FORM_C);
    $value = Normalizer::normalize('한글', $normalizationForm);

    $request = new Request();
    $request->initialize(['name' => $value]);

    $rules = ['name' => new NormalizedUnicode()];
    $validator = app('validator')->make($request->all(), $rules);

    // when
    $result = $validator->passes();

    // then
    expect($result)->toBeTrue();
});

test('invalid configured normalization form fails', function () {
    // given
    $normalizationForm = Normalizer::FORM_D;
    $value = Normalizer::normalize('한글', $normalizationForm);

    $request = new Request();
    $request->initialize(['name' => $value]);

    $rules = ['name' => new NormalizedUnicode()];
    $validator = app('validator')->make($request->all(), $rules);

    // when
    $result = $validator->passes();

    // then
    expect($result)->toBeFalse();
});

test('empty value passes', function () {
    // given
    $rules = ['name' => new NormalizedUnicode()];
    $validator = app('validator')->make(['name' => ''], $rules);

    // when
    $result = $validator->passes();

    // then
    expect($result)->toBeTrue();
});

test('integer passes', function () {
    // given
    $rules = ['name' => new NormalizedUnicode()];
    $validator = app('validator')->make(['name' => 123], $rules);

    // when
    $result = $validator->passes();

    // then
    expect($result)->toBeTrue();
});
