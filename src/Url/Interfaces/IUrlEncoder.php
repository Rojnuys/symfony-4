<?php

namespace App\Url\Interfaces;

interface IUrlEncoder
{
    /**
     * @throws \InvalidArgumentException
     */
    public function encode(string $url): string;
}