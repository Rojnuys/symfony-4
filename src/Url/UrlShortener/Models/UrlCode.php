<?php

namespace App\Url\UrlShortener\Models;

use App\Url\UrlShortener\Exceptions\UrlCodeRelationNotExistException;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class UrlCode extends Model
{
    protected $table = 'url_code';
    public $timestamps = false;

    /**
     * @throws UrlCodeRelationNotExistException
     */
    public static function getByUrl(string $url): self
    {
        $urlCode = self::where('url', $url)->first();
        if (is_null($urlCode)) {
            throw new UrlCodeRelationNotExistException();
        }
        return $urlCode;
    }

    /**
     * @throws UrlCodeRelationNotExistException
     */
    public static function getByCode(string $code): self
    {
        $urlCode = self::where('code', $code)->first();
        if (is_null($urlCode)) {
            throw new UrlCodeRelationNotExistException();
        }
        return $urlCode;
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function create(string $url, string $code): void
    {
        $urlCode = new UrlCode();
        $urlCode->url = $url;
        $urlCode->code = $code;
        $result = $urlCode->save();

        if (!$result) {
            throw new InvalidArgumentException('This url or code already exists.');
        }
    }
}