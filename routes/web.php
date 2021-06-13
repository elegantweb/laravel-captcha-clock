<?php

use Elegant\Captcha\Clock\Http\Controllers\CaptchaController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => config('captcha.clock.routes.middleware')], function () {
    Route::get('/captcha/clock/image', [CaptchaController::class, 'image'])
        ->name('captcha.clock.image');
});
