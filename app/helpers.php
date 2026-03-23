<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('r2_url')) {
    function r2_url($path)
    {
        return $path ? Storage::disk('r2')->url($path) : null;
    }
}