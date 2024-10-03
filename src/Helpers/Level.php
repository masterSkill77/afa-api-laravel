<?php

namespace Masterskill\AfaApiLaravel\Helpers;

class Level
{
    public static function getLevel(mixed $side): int
    {
        return match ((int) ceil($side)) {
            180 => 0.5,
            155 => 2.5,
            130 => 16,
            105 => 90.5,
            80 => 512,
        };
    }
}
