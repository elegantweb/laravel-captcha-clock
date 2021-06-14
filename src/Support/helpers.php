<?php

if (!function_exists('captcha_clock_check')) {
    function captcha_clock_check(int $hour, int $minute): bool
    {
        $secret = session()->get('captcha.clock');

        return [$hour, $minute] === $secret;
    }
}

if (!function_exists('captcha_clock_src')) {
    function captcha_clock_src(array $params = []): string
    {
        return route('captcha.clock.image', $params);
    }
}
