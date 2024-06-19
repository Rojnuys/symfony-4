<?php

namespace App\ExchangeRatesApiSdk\PrivatBank;

use App\ExchangeRatesApiSdk\DTO\ExchangeRateDTO;
use App\ExchangeRatesApiSdk\Factories\ExchangeRateDTOFactory;
use App\ExchangeRatesApiSdk\Interfaces\IExchangeRatesSdk;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class PrivatBankSdk implements IExchangeRatesSdk
{
    const EXCHANGE_RATES_URL = 'https://api.privatbank.ua/p24api/pubinfo';

    public function __construct(
        protected HttpClientInterface $client,
        protected ExchangeRateDTOFactory $factory
    )
    {
    }

    /**
     * @throws \InvalidArgumentException
     * @return array<ExchangeRateDTO>
     */
    public function getExchangeRates(): array
    {
        try {
            $response = $this->client->request(
                'GET',
                static::EXCHANGE_RATES_URL
            );

            $data = $this->handleResponse($response);

            return $this->getMappedResponseArray($data);
        } catch (\Throwable $e) {
            throw new \InvalidArgumentException('Oops, something went wrong.');
        }
    }


    /**
     * @param ResponseInterface $response
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws \Exception
     */
    private function handleResponse(ResponseInterface $response): array
    {
        $statusCode = $response->getStatusCode();

        if ($statusCode !== 200) {
            throw new \Exception("Unexpected response status: $statusCode");
        }

        return $response->toArray();
    }

    /**
     * @param array $data
     * @return array<ExchangeRateDTO>
     * @throws \InvalidArgumentException
     */
    private function getMappedResponseArray(array $data): array
    {
        $exchangeRates = [];

        foreach ($data as $item) {
            $exchangeRates[] = $this->factory->fromArray($item);
        }

        return $exchangeRates;
    }
}