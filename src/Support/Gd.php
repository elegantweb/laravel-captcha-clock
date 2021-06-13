<?php

namespace Elegant\Captcha\Clock\Support;

use GdImage;

class Gd
{
    public static function drawTickEllipse(
        GdImage $image,
        int $thickness,
        int $centerX,
        int $centerY,
        int $width,
        int $height,
        Color $color
    ) {
        $line = 0;
        while ($line < $thickness) {
            $line++;
            $width--;
            imageellipse($image, $centerX, $centerY, $width, $height, $color->allocate($image));
            $height--;
        }
    }
}
