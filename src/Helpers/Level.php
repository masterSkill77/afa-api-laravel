<?php

namespace Masterskill\AfaApiLaravel\Helpers;

class Level
{
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
        return (6 / 10);
        return match ((int) ceil($side)) {
            6 => 155,
            1024 => 80,
            181 => 105,
            32 => 130,
            1 => 180,
            default => function () use ($side) {
                $level = $side / 10;
                return $level * 10;
            }
        };
    }
}
