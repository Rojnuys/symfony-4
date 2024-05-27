<?php

namespace App\Url\UrlShortener\Exceptions;

use Exception;
use Throwable;

class UrlCodeCreateException extends \InvalidArgumentException
{
    public function __construct(
        string $message = "Invalid code create. Try increase the length UrlShortener.",
        int $code = 0,
        ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}