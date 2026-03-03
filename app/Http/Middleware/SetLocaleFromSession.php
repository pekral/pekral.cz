<?php

declare(strict_types = 1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class SetLocaleFromSession
{

    private const string SESSION_KEY = 'locale';

    /**
     * @param \Closure(\Illuminate\Http\Request): \Symfony\Component\HttpFoundation\Response $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->session()->get(self::SESSION_KEY);
        /** @var array<string> $supported */
        $supported = config('app.supported_locales', ['en', 'cs']);

        if (is_string($locale) && in_array($locale, $supported, true)) {
            $request->setLocale($locale);
            app()->setLocale($locale);
        }

        return $next($request);
    }

}
