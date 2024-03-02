<?php

use Illuminate\Http\Request;
use Junholee14\LaravelUnicodeNormalizer\Middlewares\NormalizeUnicode;

it('can normalize unicode in query string successfully', function () {
    // given
    $middleware = new NormalizeUnicode();
    $request = new Request();
    $nfd = Normalizer::normalize('한글', Normalizer::FORM_D);
    $nfc = Normalizer::normalize('한글', Normalizer::FORM_C);

    $request->initialize(['nfd' => $nfd]);
    $next = function ($request) {
        return $request;
    };

    // when
    $result = $middleware->handle($request, $next)->query('nfd');

    // then
    expect($result)->toBe($nfc);
});

it('can normalize unicode in json successfully', function () {
    // given
    $middleware = new NormalizeUnicode();
    $request = new Request();
    $nfd = Normalizer::normalize('한글', Normalizer::FORM_D);
    $nfc = Normalizer::normalize('한글', Normalizer::FORM_C);

    $request->initialize([], [], [], [], [], [], json_encode(['nfd' => $nfd]));
    $request->headers->set('Content-Type', 'application/json');
    $next = function ($request) {
        return $request;
    };

    // when
    $result = $middleware->handle($request, $next)->getContent();
    $result = json_decode($result, true);

    // then
    expect($result['nfd'])->toBe($nfc);
});

it('can normalize unicode in multi dimensional array in json successfully', function () {
    // given
    $middleware = new NormalizeUnicode();
    $request = new Request();
    $nfd = Normalizer::normalize('한글', Normalizer::FORM_D);
    $nfc = Normalizer::normalize('한글', Normalizer::FORM_C);

    $request->initialize([], [], [], [], [], [], json_encode(['nfd' => ['nfd' => $nfd]]));
    $request->headers->set('Content-Type', 'application/json');
    $next = function ($request) {
        return $request;
    };

    // when
    $result = $middleware->handle($request, $next)->getContent();
    $result = json_decode($result, true);

    // then
    expect($result['nfd']['nfd'])->toBe($nfc);
});

test('empty json passes', function () {
    // given
    $middleware = new NormalizeUnicode();
    $request = new Request();
    $next = function ($request) {
        return $request;
    };
    $request->headers->set('Content-Type', 'application/json');

    // when
    $result = $middleware->handle($request, $next)->getContent();

    // then
    expect($result)->toBe('');
});

it('can normalize unicode in form data successfully', function () {
    // given
    $middleware = new NormalizeUnicode();
    $request = new Request();
    $nfd = Normalizer::normalize('한글', Normalizer::FORM_D);
    $nfc = Normalizer::normalize('한글', Normalizer::FORM_C);

    $request->initialize([], ['nfd' => $nfd]);
    $next = function ($request) {
        return $request;
    };

    // when
    $result = $middleware->handle($request, $next)->request->get('nfd');

    // then
    expect($result)->toBe($nfc);
});

it('can normalize unicode in multi dimensional array in form data successfully', function () {
    // given
    $middleware = new NormalizeUnicode();
    $request = new Request();
    $nfd = Normalizer::normalize('한글', Normalizer::FORM_D);
    $nfc = Normalizer::normalize('한글', Normalizer::FORM_C);

    $request->initialize([], ['nfd' => ['nfd' => $nfd]]);
    $next = function ($request) {
        return $request;
    };

    // when
    $result = $middleware->handle($request, $next)->get('nfd')['nfd'];

    // then
    expect($result)->toBe($nfc);
});
