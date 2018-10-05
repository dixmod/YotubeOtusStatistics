<?php

namespace App\Client\Interfaces;


interface ResponseInterface
{
    public function getBody(): array;

    public function getStatusCode(): int;

    public function isOkStatus(): bool;
}