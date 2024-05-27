<?php

namespace App\Url\Interfaces;

use App\Url\UrlShortener\Exceptions\UrlCodeCreateException;
use App\Url\UrlShortener\Exceptions\UrlCodeRelationNotExistException;
use InvalidArgumentException;

interface IUrlShortener
{
    /**
     * @throws InvalidArgumentException
     * @throws UrlCodeRelationNotExistException
     */
    public function decode(string $code): string;

    /**
     * @throws InvalidArgumentException
     * @throws UrlCodeCreateException
     */
    public function encode(string $url): string;
}