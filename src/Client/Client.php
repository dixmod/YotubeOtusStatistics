<?php

namespace App\Client;

use App\Client\Interfaces\ClientInterface;
use App\Client\Interfaces\ResponseInterface;
use GuzzleHttp\Client as HttpClient;
use Psr\Log\LoggerInterface;


class Client implements ClientInterface
{
    private $client;

    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';

    private $logger;

    public function __construct(array $config, LoggerInterface $logger = null)
    {
        $this->client = new HttpClient($config);

        $this->logger = $logger;
    }

    /**
     * @param string $uri
     * @param array $params
     * @param array $options
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(string $uri, array $params = [], array $options = []): ResponseInterface
    {
        return $this->request(
            self::METHOD_GET,
            $uri . '?' . http_build_query($params),
            $options
        );
    }

    /**
     * @param string $uri
     * @param array $data
     * @param array $options
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post(string $uri, array $data =[], array $options = []): ResponseInterface
    {
        $options['json'] = $data;
        return $this->request(self::METHOD_POST, $uri, $options);
    }

    /**
     * @param string $uri
     * @param array $options
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(string $uri, array $options = []): ResponseInterface
    {
        return $this->request(self::METHOD_DELETE, $uri, $options);
    }

    /**
     * @param string $uri
     * @param array $data
     * @param array $options
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function put(string $uri, array $data =[], array $options = []): ResponseInterface
    {
        $options['json'] = $data;
        return $this->request(self::METHOD_PUT, $uri, $options);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function request(string $method, string $uri, array $options = []): ResponseInterface
    {
        try {
            $request = $this->client->request($method, $uri, $options);
            $response = new Response($request);

            $this->logger->info(
                sprintf('Response to api: %s', $uri),
                [
                    'request_data' => $options,
                    'response_data' => $response->getBody()
                ]
            );

            return $response;
        } catch (\Exception $exception) {
            $this->logger->error(
                sprintf('Fail response to api: %s', $uri),
                [
                    'request_data' => $options,
                    'exception' => $exception->getMessage(),
                    'exception_trace' => $exception->getTrace()
                ]
            );
        }
    }
}