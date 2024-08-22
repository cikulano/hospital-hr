<?php

if (!function_exists('asset_url')) {
    function asset_url($path)
    {
        if (config('app.env') === 'production') {
            return secure_asset($path);
        }
        return asset($path);
    }
}

if (!function_exists('secure_route')) {
    function secure_route($name, $parameters = [], $absolute = true)
    {
        if (config('app.env') === 'production') {
            return str_replace('http://', 'https://', route($name, $parameters, $absolute));
        }
        return route($name, $parameters, $absolute);
    }
}
