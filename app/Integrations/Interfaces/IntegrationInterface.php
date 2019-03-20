<?php

namespace App\Integrations\Interfaces;

interface IntegrationInterface
{
    public function get(string $uri);

    public function makeRequest(string $method, string $url, int $attempts);

    public function getClient();

    public function URLParameters();

    public function url(string $uri);

    public function version();

    public function baseURL();

    public function auth();

    public function getPayload($response);
}