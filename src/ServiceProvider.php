<?php

namespace Elegant\Captcha\Clock;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        $validator = $this->app['validator'];
        $validator->extend('captcha_clock', function ($attribute, $value, $parameters) {
            return captcha_clock_check($value['hour'], $value['minute']);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/captcha.clock.php', 'captcha.clock');
    }
}
