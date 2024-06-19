<?php

namespace App\ExchangeRatesApiSdk\Interfaces;

use App\ExchangeRatesApiSdk\DTO\ExchangeRateDTO;

interface IExchangeRatesSdk
{
    /**
     * @throws \InvalidArgumentException
     * @return array<ExchangeRateDTO>
     */
    public function getExchangeRates(): array;
}