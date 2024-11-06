<?php

namespace Masterskill\AfaApiLaravel\Helpers;

class Level
{
    const CITY_LEVEL = 1;
    public static function getLevel(mixed $side): mixed
    {
        return match ((int) ceil($side)) {
            180 => 0.5,
            155 => 2.5,
            130 => 16,
            105 => 90.5,
            80 => 512,
            default => null
        };
    }

    public static function getLevelFromResponse(mixed $side): int
    {
        switch (($side)) {
            case $side < 2.5:
                return 180;
            case    2.5 <= $side && $side < 15:
                return 155;
            case 15 <= $side && $side < 100:
                return 130;
            case 100 <= $side && $side < 600:
                return 105;
            case 600 <= $side:
                return 80;
        }
    }
}
