<?php

use Elegant\Captcha\Clock\Http\Controllers\CaptchaController;

Route::get('/captcha/clock/image', [CaptchaController::class, 'image'])->name('captcha.clock.image');
