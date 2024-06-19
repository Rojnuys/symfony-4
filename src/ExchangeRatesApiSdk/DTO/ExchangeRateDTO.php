<?php

namespace App\ExchangeRatesApiSdk\DTO;

class ExchangeRateDTO
{
    public function __construct(
        public readonly string $ccy,
        public readonly string $baseCcy,
        public readonly float|int $buy,
        public readonly float|int $sale
    )
    {
    }
}