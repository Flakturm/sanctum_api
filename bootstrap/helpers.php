<?php

if (!function_exists('str_slug')) {
    function str_slug($string, $separator)
    {
        $slug = mb_strtolower(
            preg_replace('/([?]|\p{P}|\s)+/u', $separator, $string)
        );
        return trim($slug, $separator);
    }
}

if (!function_exists('str_boolean')) {
    function str_boolean(string $string): bool
    {
        return filter_var($string, FILTER_VALIDATE_BOOLEAN);
    }
}
