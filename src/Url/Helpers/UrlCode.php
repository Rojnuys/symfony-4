<?php

namespace App\Url\Helpers;

class UrlCode
{
    public static function create(int $length): string
    {
        $code = '';

        for ($i = 0; $i < $length; $i++) {
            $code .= self::getRandomUrlSymbol();
        }

        return $code;
    }

    protected static function getRandomUrlSymbol(): string
    {
        $availableUrlSymbols = '0123456789-abcdefghijklmnopqrstuvwxyz';
        return $availableUrlSymbols[rand(0, strlen($availableUrlSymbols) - 1)];
    }
}