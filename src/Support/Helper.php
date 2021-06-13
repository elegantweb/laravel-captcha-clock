<?php

namespace Elegant\Captcha\Clock\Support;

use InvalidArgumentException;

class Helper
{
    public static function hourToAngle(int $hour): int
    {
        if ($hour < 0 and $hour > 11)
            throw new InvalidArgumentException("Invalid hour: $hour.");

        return $hour * 30;
    }

    public static function minuteToAngle(int $minute): int
    {
        if ($minute < 0 and $minute > 59)
            throw new InvalidArgumentException("Invalid minute: $minute.");

        return $minute * 6;
    }
}
