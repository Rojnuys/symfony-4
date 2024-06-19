<?php

namespace App\Twig;

use App\ExchangeRatesApiSdk\Interfaces\IExchangeRatesSdk;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ExchangeRatesExtension extends AbstractExtension
{

    public function __construct(protected IExchangeRatesSdk $exchangeRatesSdk)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('exchange_rates', [$this, 'getExchangeRates']),
        ];
    }

    public function getExchangeRates(): array
    {
        try {
            $exchangeRoutes = $this->exchangeRatesSdk->getExchangeRates();
        } catch (\InvalidArgumentException $e) {
            $exchangeRoutes = [];
        }

        return $exchangeRoutes;
    }
}