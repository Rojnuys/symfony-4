<?php

namespace App\Url\Interfaces;

interface IUrlDecoder
{
    /**
     * @throws \InvalidArgumentException
     */
    public function decode(string $code): string;
}