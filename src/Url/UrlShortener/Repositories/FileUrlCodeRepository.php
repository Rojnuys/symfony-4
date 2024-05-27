<?php

namespace App\Url\UrlShortener\Repositories;

use App\FileSystem\File;
use App\Url\UrlShortener\Exceptions\UrlCodeRelationNotExistException;
use App\Url\UrlShortener\Interfaces\IUrlCodeRepository;
use Closure;
use InvalidArgumentException;

class FileUrlCodeRepository implements IUrlCodeRepository
{
    protected static string $urlCodeSeparator = '|';

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(protected string $filePath)
    {
        File::createIfNotExist($filePath);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function append(string $url, string $code): void
    {
        File::append($this->filePath, self::createUrlCodeRelation($url, $code) . "\n");
    }

    /**
     * @throws InvalidArgumentException
     * @throws UrlCodeRelationNotExistException
     */
    public function getUrl(string $code): string
    {
        return $this->getRelation(
            $code,
            fn (string $code, array $urlCodeRelation): bool => $urlCodeRelation[1] === $code
        )[0];
    }

    /**
     * @throws InvalidArgumentException
     * @throws UrlCodeRelationNotExistException
     */
    public function getCode(string $url): string
    {
        return $this->getRelation(
            $url,
            fn (string $url, array $urlCodeRelation): bool => $urlCodeRelation[0] === $url
        )[1];
    }

    /**
     * @throws InvalidArgumentException
     * @throws UrlCodeRelationNotExistException
     */
    protected function getRelation(string $data, Closure $compareClb): array
    {
        $fileGen = File::getLineReaderGenerator($this->filePath);

        foreach ($fileGen as $line) {
            $urlCodeRelation = self::parseUrlCodeRelation($line);

            if ($compareClb($data, $urlCodeRelation)) {
                return $urlCodeRelation;
            }
        }

        throw new UrlCodeRelationNotExistException();
    }

    /**
     * @throws InvalidArgumentException
     */
    protected static function parseUrlCodeRelation(string $data): array
    {
        $urlCodeRelation = explode(self::$urlCodeSeparator, $data);

        if (count($urlCodeRelation) !== 2) {
            throw new InvalidArgumentException('Invalid format. A URL-code relation must have url and code separated by a '
                . self::$urlCodeSeparator . '.');
        }

        return $urlCodeRelation;
    }

    protected static function createUrlCodeRelation(string $url, string $code): string
    {
        return $url . self::$urlCodeSeparator . $code;
    }
}