<?php

namespace Elegant\Captcha\Clock\Http\Controllers;

use Elegant\Captcha\Clock\Captcha;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class CaptchaController extends Controller
{
    public function image(Request $request)
    {
        $hour = rand(0, 11);
        $minute = rand(0, 59);

        $request->session()->put('captcha.clock', [$hour, $minute]);

        $captcha = new Captcha();
        $captcha->setWidth($request->input('w', 200));
        $captcha->setHeight($request->input('h', 200));
        $captcha->setHour($hour);
        $captcha->setMinute($minute);
        $content = $captcha->render();

        return response($content, 200, ['Content-Type' => 'image/png']);
    }
}
