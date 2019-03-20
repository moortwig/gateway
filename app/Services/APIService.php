<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

abstract class APIService
{
    /** @var  string */
    protected $version;

    /** @var  string */
    protected $baseURL;

    /** @var  string */
    protected $format;

    /**
     * @param string $uri
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     */
    public function get(string $uri)
    {
        $url = $this->url($uri);
        $response = $this->makeRequest('GET', $url);

        return $response;
    }

    /**
     * @param string $method
     * @param string $url
     * @param int    $attempts
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     */
    public function makeRequest(string $method, string $url, int $attempts = 0)
    {
        $client = $this->getClient();
        $response = null;

        try {
            Log::info('APIService->makeRequest: Attempts: ' . $attempts);
            $response = $client->request($method, $url, $this->auth(), [
                'query' => $this->URLParameters(),
            ]);

        } catch (\Exception $e) {
            Log::error('APIService->makeRequest: ' . $e->getMessage());

            $attempts++;
            if ($attempts < 3) {
                $this->makeRequest($method, $url, $attempts);
            } else {
                Log::error('APIService->makeRequest: Maximum attempts made. Dropping request.');
            }
        }

        return $response;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return new Client([
            $this->headers(),
            'base_uri' => $this->baseURL(),
        ]);
    }

    /**
     * @return string
     */
    public function baseURL()
    {
        return $this->baseURL;
    }

    /**
     * @return string
     */
    public function version()
    {
        return $this->version;
    }

    /**
     * @return string
     */
    public function format()
    {
        return $this->format;
    }
}