<?php

namespace Probytech\Proadmin\Helpers;

class ViteHelper
{
    /**
     * Get the Vite asset URL for ProAdmin
     */
    public static function asset(string $asset): string
    {
        $manifestPath = public_path('vendor/proadmin/build/.vite/manifest.json');

        if (!file_exists($manifestPath)) {
            return asset("vendor/proadmin/build/assets/{$asset}");
        }

        $manifest = json_decode(file_get_contents($manifestPath), true);

        if (isset($manifest[$asset])) {
            return asset('vendor/proadmin/build/' . $manifest[$asset]['file']);
        }

        return asset("vendor/proadmin/build/assets/{$asset}");
    }

    /**
     * Get the CSS asset URL
     */
    public static function css(): string
    {
        return self::asset('resources/css/app.css');
    }
}
