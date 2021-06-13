<?php

namespace Elegant\Captcha\Clock;

use Elegant\Captcha\Clock\Support\Color;
use Elegant\Captcha\Clock\Support\Helper;

class Captcha
{
    protected int $width = 200;
    protected int $height = 200;
    protected int $hour = 0;
    protected int $minute = 0;

    public function setWidth(int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function setHour(int $hour): self
    {
        $this->hour = $hour;

        return $this;
    }

    public function setMinute(int $minute): self
    {
        $this->minute = $minute;

        return $this;
    }

    public function render(): string
    {
        $board = new CaptchaBoard($this->width, $this->height);

        $board->drawFace(Color::createRandomLightColor());

        $board->drawHourPoints(4, 8, new Color(0, 0, 0, 0));
        $board->drawMinutePoints(2, 4, new Color(0, 0, 0, 0));

        $hourHandColor = Color::createRandomDarkColor();
        $minuteHandColor = Color::createRandomDarkColor();

        $board->drawHand(4, 32, Helper::hourToAngle($this->hour, $this->minute), $hourHandColor);
        $board->drawHand(2, 64, Helper::minuteToAngle($this->minute), $minuteHandColor);

        $board->drawBorder(new Color(0, 0, 0, 0));

        $board->drawRandomEllipse(6, $hourHandColor);
        $board->drawRandomRectangle(2, $minuteHandColor);
        $board->drawRandomTriangle(4, $minuteHandColor);

        return $board->render();
    }
}
