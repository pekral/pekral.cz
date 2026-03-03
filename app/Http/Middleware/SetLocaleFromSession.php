<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class SetLocaleFromSession
{
    private const SESSION_KEY = 'locale';

    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->session()->get(self::SESSION_KEY);

        if ($locale !== null && in_array($locale, config('app.supported_locales', ['en', 'cs']), true)) {
            $request->setLocale($locale);
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
