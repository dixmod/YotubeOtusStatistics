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

    /**
     * @return array
     */
    public function getBody(): array
    {
        $body = (string)$this->response->getBody();
        $arrayBody = json_decode($body, true);

        return $arrayBody;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return (int)$this->response->getStatusCode();
    }

    /**
     * @return bool
     */
    public function isOkStatus(): bool
    {
        return 200 === $this->getStatusCode();
    }

}