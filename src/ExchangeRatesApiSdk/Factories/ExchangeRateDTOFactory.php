<?php

namespace App\ExchangeRatesApiSdk\Factories;

use App\ExchangeRatesApiSdk\DTO\ExchangeRateDTO;

class ExchangeRateDTOFactory
{

    /**
     * @param array $data
     * @throws \InvalidArgumentException
     * @return ExchangeRateDTO
     */
    public function fromArray(array $data): ExchangeRateDTO
    {
        if (
            !isset($data['ccy']) || !isset($data['base_ccy'])
            || !isset($data['buy']) || !isset($data['sale'])
        ) {
            throw new \InvalidArgumentException('There are not enough parameters to create ExchangeRateDTO');
        }

        return new ExchangeRateDTO($data['ccy'], $data['base_ccy'], $data['buy'], $data['sale']);
    }
}