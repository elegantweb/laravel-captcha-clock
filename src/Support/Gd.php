<?php

namespace Elegant\Captcha\Clock\Support;

class Gd
{
    public static function makeBgTransparent($image)
    {
        $transparency = imagecolorallocatealpha($image, 255, 255, 255, 127);
        imagefill($image, 0, 0, $transparency);
    }

    public static function rotateTransparently($image, float $angle)
    {
        $transparency = imagecolorallocatealpha($image, 255, 255, 255, 127);
        return imagerotate($image, $angle, $transparency);
    }

    public static function drawTickEllipse(
        $image,
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
