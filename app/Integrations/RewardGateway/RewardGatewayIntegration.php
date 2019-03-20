<?php

namespace App\Integrations\RewardGateway;

use App\Integrations\Interfaces\IntegrationInterface;
use App\Services\APIService;

class RewardGatewayIntegration extends APIService implements IntegrationInterface
{

    public function __construct()
    {
        $this->baseURL = config('integrations.reward_gateway.base_url');
        $this->format = config('integrations.reward_gateway.format');
        $this->version = null;
    }

    /**
     * Build the URL for the request
     *
     * @param string $uri
     * @return string
     */
    public function url(string $uri)
    {
        return sprintf($this->format(), $this->baseURL(), $uri);
    }

    public function URLParameters()
    {
        return [
            'Authorization' => config('integrations.reward_gateway.param.authorization'),
        ];
    }

    public function auth()
    {
        return ['auth' => [
            config('integrations.reward_gateway.auth.username'),
            config('integrations.reward_gateway.auth.password'),
        ]];
    }

    public function headers()
    {
        return $this->auth();
    }

    public function getPayload($response)
    {
        return $response->getBody()->getContents();
    }
}