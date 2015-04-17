<?php

if (!function_exists('publicPath')) {
    function publicPath($path = '')
    {
        return __DIR__."/../public/$path";
    }
}
