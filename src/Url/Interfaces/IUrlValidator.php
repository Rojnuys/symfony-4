<?php

namespace App\Url\Interfaces;

use InvalidArgumentException;

interface IUrlValidator
{
    /**
     * @throws InvalidArgumentException
     */
    public function checkUrl(string $url): void;

    /**
     * @throws InvalidArgumentException
     */
    public function checkRealUrl(string $url): void;
}