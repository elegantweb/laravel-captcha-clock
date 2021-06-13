<?php

namespace Elegant\Captcha\Clock;

use Elegant\Captcha\Clock\Support\Helper;
use Elegant\Captcha\Clock\Support\Color;
use Elegant\Captcha\Clock\Support\Gd;
use GdImage;

class CaptchaBoard
{
    protected GdImage $image;

    public function __construct(int $width, int $height)
    {
        $this->image = imagecreatetruecolor($width, $height);

        imagesavealpha($this->image, true);
        $transparency = imagecolorallocatealpha($this->image, 0, 0, 0, 127);
        imagefill($this->image, 0, 0, $transparency);
    }

    public function drawFace(Color $color): self
    {
        $img = $this->image;

        $width = imagesx($img);
        $height = imagesx($img);

        $bg = $color->allocate($img);
        imagefilledellipse($img, $width / 2, $height / 2, $width, $height, $bg);

        return $this;
    }

    public function drawBorder(Color $color): self
    {
        $img = $this->image;

        $width = imagesx($img);
        $height = imagesx($img);

        $bg = $color->allocate($img);
        imageellipse($img, $width / 2, $height / 2, $width - 8, $height - 8, $bg);
        imagefilledellipse($img, $width / 2, $height / 2, 8, 8, $bg);

        return $this;
    }

    public function drawHourPoints(int $pointWidth, int $pointHeight, Color $color): self
    {
        for ($h = 0; $h < 12; $h++)
            $this->drawPoint(Helper::hourToAngle($h), $pointWidth, $pointHeight, $color);

        return $this;
    }

    public function drawMinutePoints(int $pointWidth, int $pointHeight, Color $color): self
    {
        for ($m = 0; $m < 60; $m++)
            $this->drawPoint(Helper::minuteToAngle($m), $pointWidth, $pointHeight, $color);

        return $this;
    }

    public function drawPoint(int $angle, int $pointWidth, int $pointHeight, Color $color): self
    {
        $faceImg = $this->image;
        $faceWidth = imagesx($faceImg);
        $faceHeight = imagesx($faceImg);

        $pointImg = imagecreatetruecolor($faceWidth, $faceHeight);

        $bg = imagecolorallocatealpha($pointImg, 0, 0, 0, 127);
        imagefill($pointImg, 0, 0, $bg);

        $bg = $color->allocate($pointImg);
        imagefilledrectangle($pointImg, ($faceWidth / 2) - ($pointWidth / 2), 0, ($faceWidth / 2) + ($pointWidth / 2), $pointHeight, $bg);

        $bg = imagecolorallocatealpha($pointImg, 0, 0, 0, 127);
        $pointImg = imagerotate($pointImg, $angle * -1, $bg);

        $rotatedWidth = imagesx($pointImg);
        $rotatedHeight = imagesy($pointImg);

        imagecopy($faceImg, $pointImg, ($faceWidth / 2) - ($rotatedWidth / 2), ($faceHeight / 2) - ($rotatedHeight / 2), 0, 0, $rotatedWidth, $rotatedHeight);

        imagedestroy($pointImg);

        return $this;
    }

    public function drawHand(int $handWidth, int $handHeight, int $angle, Color $color): self
    {
        $faceImg = $this->image;
        $faceWidth = imagesx($faceImg);
        $faceHeight = imagesx($faceImg);

        $width = $handHeight * 2;
        $height = $handHeight * 2;
        $handImg = imagecreatetruecolor($width, $height);

        $bg = imagecolorallocatealpha($handImg, 0, 0, 0, 127);
        imagefill($handImg, 0, 0, $bg);

        $bg = $color->allocate($handImg);
        imagefilledrectangle($handImg, ($width / 2) - ($handWidth / 2), 0, ($width / 2) + ($handWidth / 2), $height / 2, $bg);

        $bg = imagecolorallocatealpha($handImg, 0, 0, 0, 127);
        $handImg = imagerotate($handImg, $angle * -1, $bg);

        $rotatedWidth = imagesx($handImg);
        $rotatedHeight = imagesy($handImg);

        imagecopy($faceImg, $handImg, ($faceWidth / 2) - ($rotatedWidth / 2), ($faceHeight / 2) - ($rotatedHeight / 2), 0, 0, $rotatedWidth, $rotatedHeight);

        imagedestroy($handImg);

        return $this;
    }

    public function drawRandomEllipse(int $thickness, Color $color): self
    {
        $width = imagesx($this->image);
        $height = imagesx($this->image);

        Gd::drawTickEllipse(
            $this->image,
            $thickness,
            rand(($width / 6) * 3, ($width / 6) * 4),
            rand(($height / 6) * 3, ($height / 6) * 4),
            rand($width / 4, $width / 2),
            rand($height / 4, $height / 2),
            $color
        );

        return $this;
    }

    public function drawRandomRectangle(int $thickness, Color $color): self
    {
        $width = imagesx($this->image);
        $height = imagesx($this->image);

        imagesetthickness($this->image, $thickness);

        imagerectangle(
            $this->image,
            $width / 2,
            $height / 2,
            [rand(0, ($width / 2) - ($width / 6)), rand(($width / 2) + ($width / 6), $width)][rand(0, 1)],
            [rand(0, ($height / 2) - ($height / 6)), rand(($height / 2) + ($height / 6), $height)][rand(0, 1)],
            $color->allocate($this->image)
        );

        return $this;
    }

    public function drawRandomTriangle(int $thickness, Color $color): self
    {
        $width = imagesx($this->image);
        $height = imagesx($this->image);

        $quarters = [
            ['x' => [0, $width / 2], 'y' => [0, $height / 2]],
            ['x' => [0, $width / 2], 'y' => [$height / 2, $height]],
            ['x' => [$width / 2, $width], 'y' => [0, $height / 2]],
            ['x' => [$width / 2, $width], 'y' => [$height / 2, $height]],
        ];

        $quarter = $quarters[rand(0, 3)];

        imagesetthickness($this->image, $thickness);

        $points = [
            ($width / 2), ($height / 2),
            rand($quarter['x'][0], $quarter['x'][1]), rand($quarter['y'][0], $quarter['y'][1]),
            rand($quarter['x'][0], $quarter['x'][1]), rand($quarter['y'][0], $quarter['y'][1]),
        ];

        imagepolygon($this->image, $points, $color->allocate($this->image));

        return $this;
    }

    public function render(): string
    {
        ob_start();
        imagepng($this->image);
        $data = ob_get_contents();
        ob_end_clean();

        imagedestroy($this->image);

        return $data;
    }
}
