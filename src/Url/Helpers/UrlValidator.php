<?php

namespace App\Url\Helpers;

use App\Url\Enums\HttpSuccessCode;
use App\Url\Interfaces\IUrlValidator;
use InvalidArgumentException;

class UrlValidator implements IUrlValidator
{
    /**
     * @throws InvalidArgumentException
     */
    public function checkUrl(string $url): void
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException('Invalid url.');
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    public function checkRealUrl(string $url): void
    {
        self::checkUrl($url);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT,10);
        curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if (is_null(HttpSuccessCode::tryFrom($httpcode))) {
            throw new InvalidArgumentException('The url unavailable.');
        }
    }
}