<?php

namespace App\Url\UrlShortener\Interfaces;

use App\Url\UrlShortener\Exceptions\UrlCodeRelationNotExistException;
use InvalidArgumentException;

interface IUrlCodeRepository
{
    /**
     * @throws InvalidArgumentException
     */
    public function append(string $url, string $code): void;

    /**
     * @throws InvalidArgumentException
     */
    public function getUrl(string $code): string;

    /**
     * @throws InvalidArgumentException
     */
    public function getCode(string $url): string;
}