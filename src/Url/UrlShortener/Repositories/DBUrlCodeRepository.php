<?php

namespace App\Url\UrlShortener\Repositories;

use App\Url\UrlShortener\Exceptions\UrlCodeRelationNotExistException;
use App\Url\UrlShortener\Interfaces\IUrlCodeRepository;
use App\Url\UrlShortener\Models\UrlCode;
use InvalidArgumentException;

class DBUrlCodeRepository implements IUrlCodeRepository
{
    /**
     * @throws InvalidArgumentException
     */
    public function append(string $url, string $code): void
    {
        UrlCode::create($url, $code);
    }

    /**
     * @throws UrlCodeRelationNotExistException
     */
    public function getUrl(string $code): string
    {
        return UrlCode::getByCode($code)->url;
    }

    /**
     * @throws UrlCodeRelationNotExistException
     */
    public function getCode(string $url): string
    {
        return UrlCode::getByUrl($url)->code;
    }
}