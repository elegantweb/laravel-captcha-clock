<?php

namespace Elegant\Captcha\Clock\Http\Controllers;

use Illuminate\Http\Request;

class CaptchaController
{
    public function image(Request $request)
    {
        $hour = rand(0, 11);
        $minute = rand(0, 59);

        $request->session()->put('captcha.clock', [$hour, $minute]);

        $captcha = new Captcha();
        $captcha->setHour($hour);
        $captcha->setMinute($minute);
        $content = $captcha->render();

        return response($content, 200, ['Content-Type' => 'image/png']);
    }
}
