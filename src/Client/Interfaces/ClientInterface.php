<?php

namespace App\Client\Interfaces;


interface ClientInterface
{
    public function get(string $uri, array $options = []): ResponseInterface;

    public function post(string $uri, array $data =[], array $options = []): ResponseInterface;

    public function delete(string $uri, array $options = []): ResponseInterface;

    public function put(string $uri, array $data =[], array $options = []): ResponseInterface;
}