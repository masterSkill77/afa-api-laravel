<?php

namespace Masterskill\AfaApiLaravel\Helpers;

class Level
{
    public static function getLevel(mixed $side): int
    {
        return match ((int) ceil($side)) {
            6 => 155,
            1024 => 80,
            181 => 105,
            32 => 130,
            6 => 155,
            1 => 180,
        };
    }
}
