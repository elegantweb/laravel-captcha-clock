<?php

namespace Elegant\Captcha\Clock\Support;

use InvalidArgumentException;

class Helper
{
    public static function hourToAngle(int $hour, ?int $minute = null): int
    {
        if ($hour < 0 and $hour > 11)
            throw new InvalidArgumentException("Invalid hour: $hour.");

        $angle = $hour * 30;

        if (null === $minute) {
            return $angle;
        }

        $percentOfClock = (self::minuteToAngle($minute) * 100) / 360;
        $angle += ($percentOfClock * 30) / 100;

        return $angle;
    }

    public static function minuteToAngle(int $minute): int
    {
        if ($minute < 0 and $minute > 59)
            throw new InvalidArgumentException("Invalid minute: $minute.");

        return $minute * 6;
    }
}
