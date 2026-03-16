<?php

/**
 * Get public asset path
 * @param string $path
 * @return string
 */
if (!function_exists('public_asset')) {
    function public_asset($path)
    {
        $path = ltrim($path, '/');
        if(env('APP_ENV') == 'local'){
            return config('app.url') . '/' . $path;
        }
        return config('app.url') . 'public/' . $path;
    }
}