<?php

namespace Elegant\Captcha\Clock\Support;

use GdImage;

class Color
{
    private int $red;
    private int $green;
    private int $blue;
    private int $alpha;

    public function __construct(int $red, int $green, int $blue, int $alpha)
    {
        $this->red = $red;
        $this->green = $green;
        $this->blue = $blue;
        $this->alpha = $alpha;
    }

    public function getRed(): int
    {
        return $this->red;
    }

    public function getGreen(): int
    {
        return $this->green;
    }

    public function getBlue(): int
    {
        return $this->blue;
    }

    public function getAlpha(): int
    {
        return $this->alpha;
    }

    public function allocate(GdImage $img): int|false
    {
        return imagecolorallocatealpha(
            $img,
            $this->getRed(),
            $this->getGreen(),
            $this->getBlue(),
            $this->getAlpha()
        );
    }

    public static function createRandomDarkColor(): self
    {
        $red = floor(rand(0, 256 / 2));
        $green = floor(rand(0, 256 / 2));
        $blue = floor(rand(0, 256 / 2));

        return new self($red, $green, $blue, 0);
    }

    public static function createRandomLightColor(): self
    {
        $red = floor(rand(256 / 2, 255));
        $green = floor(rand(256 / 2, 255));
        $blue = floor(rand(256 / 2, 255));

        return new self($red, $green, $blue, 0);
    }
}
