<?php

namespace Masterskill\AfaApiLaravel\Helpers;

class Level
{
    const CITY_LEVEL = 1;

    /**
     * This method change our level into side. The side will be passed into the AFACode API
     * @param mixed $level The level from the application
     * @return mixed The side
     */
    public static function getLevel(mixed $level): mixed
    {
        return match ((int) ceil($level)) {
            180 => 0.5,
            155 => 2.5,
            130 => 16,
            105 => 90.5,
            80 => 512,
            default => null
        };
    }

    /**
     * From AFACode, we don't have level but side. This method make correspondance with side and our level
     *  @param mixed $side The side from AFACode
     * @return int The correspondant level
     */
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
