<?php

namespace App\Url\UrlShortener\Exceptions;

use Exception;
use Throwable;

class UrlCodeRelationNotExistException extends \InvalidArgumentException
{
    public function __construct(
        string $message = "The relation with these params does not exist.",
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}