<?php

namespace App\Helpers;

class ColorMap
{
    protected static array $colors = [
        'Цагаан' => '#FFFFFF',
        'Хар' => '#2D2926',
        'Цэнхэр' => '#4A6FA5',
        'Ногоон' => '#2E7D32',
        'Ягаан' => '#E91E8C',
        'Улбар шар' => '#E8651A',
        'Саарал' => '#9E9E9E',
        'Бор' => '#795548',
        'Хар зурвас' => '#333333',
    ];

    public static function hex(string $colorName): string
    {
        return static::$colors[$colorName] ?? '#CCCCCC';
    }

    public static function all(): array
    {
        return static::$colors;
    }
}
