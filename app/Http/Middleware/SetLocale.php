<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

/**
 * Reads the {locale} URL prefix (bn / en), applies it, and makes it the
 * default for route() so links stay in the current language.
 */
class SetLocale
{
    public const SUPPORTED = ['bn', 'en'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->route('locale');

        if (! in_array($locale, self::SUPPORTED, true)) {
            $locale = config('app.locale', 'bn');
        }

        app()->setLocale($locale);
        URL::defaults(['locale' => $locale]);

        // Controllers don't need the locale as an argument.
        $request->route()->forgetParameter('locale');

        return $next($request);
    }
}
