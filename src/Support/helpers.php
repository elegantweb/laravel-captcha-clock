<?php

if (!function_exists('captcha_clock_check')) {
    function captcha_clock_check($hour, $minute)
    {
        $secret = session()->get('captcha.clock');

        return [$hour, $minute] === $secret;
    }
}

if (!function_exists('captcha_clock_src')) {
    function captcha_clock_src(array $params = [])
    {
        return route('captcha.clock.image', $params);
    }
}
