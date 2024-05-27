<?php

namespace App\Url\UrlShortener;

use App\Url\Helpers\UrlCode;
use App\Url\Helpers\UrlValidator;
use App\Url\Interfaces\IUrlDecoder;
use App\Url\Interfaces\IUrlEncoder;
use App\Url\Interfaces\IUrlShortener;
use App\Url\Interfaces\IUrlValidator;
use App\Url\UrlShortener\Exceptions\UrlCodeCreateException;
use App\Url\UrlShortener\Exceptions\UrlCodeRelationNotExistException;
use App\Url\UrlShortener\Interfaces\IUrlCodeRepository;
use InvalidArgumentException;

class UrlShortener implements IUrlEncoder, IUrlDecoder, IUrlShortener
{
    const CREATE_CODE_REPEAT = 10;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        protected IUrlCodeRepository $urlCodeRepository,
        protected IUrlValidator $urlValidator,
        protected int $length = 3
    ) {
        $this->setLength($length);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setLength(int $length): void
    {
        if ($length <= 0 || $length > 10) {
            throw new InvalidArgumentException('Invalid length. Must be between 1 and 10.');
        }
        $this->length = $length;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function setUrlCodeRepository(IUrlCodeRepository $urlCodeRepository): void
    {
        $this->urlCodeRepository = $urlCodeRepository;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function decode(string $code): string
    {
        return $this->urlCodeRepository->getUrl($code);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function encode(string $url): string
    {
        $this->urlValidator->checkRealUrl($url);

        try {
            return $this->urlCodeRepository->getCode($url);
        } catch (UrlCodeRelationNotExistException $e) {
            $code = $this->createAvailableCode($url);
            $this->urlCodeRepository->append($url, $code);
        }

        return $code;
    }

    /**
     * @throws UrlCodeCreateException
     */
    protected function createAvailableCode(string $url): string
    {
        for ($i = 0; $i < self::CREATE_CODE_REPEAT; $i++) {
            $code = UrlCode::create($this->length);

            if ($this->isAvailableCode($code)) {
                return $code;
            }
        }

        throw new UrlCodeCreateException();
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function isAvailableCode(string $code): bool
    {
        try {
            $this->urlCodeRepository->getUrl($code);
        } catch (UrlCodeRelationNotExistException $e) {
            return true;
        }

        return false;
    }
}