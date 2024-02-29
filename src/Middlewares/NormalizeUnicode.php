<?php

namespace Junholee14\LaravelUnicodeNormalizer\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Normalizer;

class NormalizeUnicode
{
    public function handle(Request $request, Closure $next)
    {
        $canonicalForm = config('unicode_normalizer.canonical_form', Normalizer::FORM_C);

        if ($request->query->count() > 0) {
            $this->processQueryString($request, $canonicalForm);
        }

        if ($request->request->count() > 0) {
            $this->processFormData($request, $canonicalForm);
        }

        if ($request->isJson()) {
            $this->processJson($request, $canonicalForm);
        }

        return $next($request);
    }

    private function processQueryString(Request $request, $canonicalForm)
    {
        $request->query->replace(
            array_map(function ($item) use ($canonicalForm) {
                return is_string($item) ? Normalizer::normalize($item, $canonicalForm) : $item;
            }, $request->query->all())
        );
    }

    private function processFormData(Request $request, $canonicalForm)
    {
        $formData = $request->request->all();
        $isModified = false;
        array_walk_recursive($formData, function (&$item) use ($canonicalForm, &$isModified) {
            if (is_string($item)) {
                $item = Normalizer::normalize($item, $canonicalForm);
                $isModified = true;
            }
        });

        if ($isModified) {
            $request->request->replace($formData);
        }
    }

    private function processJson(Request $request, $canonicalForm)
    {
        $decodedContent = json_decode($request->getContent(), true);

        $isModified = false;
        array_walk_recursive($decodedContent, function (&$item) use ($canonicalForm, &$isModified) {
            if (is_string($item)) {
                $item = Normalizer::normalize($item, $canonicalForm);
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
