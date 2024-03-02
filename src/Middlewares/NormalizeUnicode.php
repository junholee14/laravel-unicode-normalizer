<?php

namespace Junholee14\LaravelUnicodeNormalizer\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Junholee14\LaravelUnicodeNormalizer\Utils\UnicodeNormalizer;

class NormalizeUnicode
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->query->count() > 0) {
            $this->processQueryString($request);
        }

        if ($request->request->count() > 0) {
            $this->processFormData($request);
        }

        if ($request->isJson()) {
            $this->processJson($request);
        }

        return $next($request);
    }

    private function processQueryString(Request $request)
    {
        $request->query->replace(
            array_map(function ($item) {
                return is_string($item) ? UnicodeNormalizer::normalize($item) : $item;
            }, $request->query->all())
        );
    }

    private function processFormData(Request $request)
    {
        $formData = $request->request->all();
        $isModified = false;
        array_walk_recursive($formData, function (&$item) use (&$isModified) {
            if (is_string($item)) {
                $item = UnicodeNormalizer::normalize($item);
                $isModified = true;
            }
        });

        if ($isModified) {
            $request->request->replace($formData);
        }
    }

    private function processJson(Request $request)
    {
        $decodedContent = json_decode($request->getContent(), true);

        $isModified = false;
        array_walk_recursive($decodedContent, function (&$item) use (&$isModified) {
            if (is_string($item)) {
                $item = UnicodeNormalizer::normalize($item);
                $isModified = true;
            }
        });

        if ($isModified) {
            $request->initialize(
                $request->query->all(),
                $request->request->all(),
                $request->attributes->all(),
                $request->cookies->all(),
                $request->files->all(),
                $request->server->all(),
                json_encode($decodedContent)
            );
        }
    }
}
