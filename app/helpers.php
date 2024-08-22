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
