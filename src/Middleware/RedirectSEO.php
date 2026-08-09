<?php

namespace Probytech\Proadmin\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectSEO
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        $domain = $request->getHost();

        $path = $request->getPathInfo();
        $query = $request->getQueryString();

        $path = preg_replace('/\/+/', '/', $path);

        // Strip a leading /public segment (front controller served from the project root instead of /public).
        $path = preg_replace('#^/public(?=/|$)#i', '', $path);

        // Strip /index.php anywhere in the path (e.g. /index.php or /index.php/foo).
        $path = preg_replace('#/index\.php#i', '', $path);

        $path = preg_replace('/\/+/', '/', $path);

        if ($path === '') {
            $path = '/';
        }

        if ($path !== '/') {
            $path = rtrim($path, '/');
        }

        if (mb_strpos($path, '%') === false) {
            $path = mb_strtolower($path);
        }

        $domain = preg_replace('/^www\./i', '', mb_strtolower($domain));

        $scheme = $request->isSecure() ? 'https' : 'http';

        // Canonicalize to https outside local/testing, where TLS is terminated
        // directly by the app's own web server (not an unrecognized upstream
        // proxy) and forcing https can't create a redirect loop.
        if ($scheme === 'http' && ! app()->environment('local', 'testing')) {
            $scheme = 'https';
        }

        $filteredUrl = "{$scheme}://{$domain}{$path}".($query !== null && $query !== '' ? "?{$query}" : '');

        $url = "{$scheme}://{$request->getHost()}{$request->getRequestUri()}";

        if ($filteredUrl != $url) {
            return redirect($filteredUrl, 301);
        }

        return $next($request);
    }
}
