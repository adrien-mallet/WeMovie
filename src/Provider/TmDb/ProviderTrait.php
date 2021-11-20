<?php


namespace App\Provider\TmDb;

use RuntimeException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

trait ProviderTrait
{
    /**
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws RuntimeException
     */
    private function decodeJsonResponse(ResponseInterface $response)
    {
        $decodedResponse = json_decode($response->getContent());

        if (($code = json_last_error()) !== JSON_ERROR_NONE) {
            throw new RuntimeException(json_last_error_msg(), $code);
        }

        return $decodedResponse;
    }

}