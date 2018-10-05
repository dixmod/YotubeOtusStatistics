<?php

namespace App\Client;


use App\Client\Interfaces\ResponseInterface;
use Psr\Http\Message\ResponseInterface as HttpResponseInterface;

class Response implements ResponseInterface
{
    private $response;

    public function __construct(HttpResponseInterface $response)
    {
        $this->response = $response;
    }

    public function getBody(): array
    {
        $body = (string)$this->response->getBody();
        $arrayBody = json_decode($body, true);

        return $arrayBody;
    }

    public function getStatusCode(): int
    {
        return (int)$this->response->getStatusCode();
    }

    public function isOkStatus(): bool
    {
        return 200 === $this->getStatusCode();
    }

}