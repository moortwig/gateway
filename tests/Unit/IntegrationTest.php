<?php

namespace Tests\Unit;

use App\Integrations\RewardGateway\RewardGatewayIntegration;
use App\Services\APIService;
use GuzzleHttp\Client;
use Tests\TestCase;

class IntegrationTest extends TestCase
{
    public function test_get_request()
    {
        try {
            $response = $this->makeRequest();
            $statusCode = ($response->getStatusCode() === 200) || ($response->getStatusCode() === 500);

            $this->assertTrue($statusCode);
            $this->assertJson($response->getBody()->getContents());
        } catch (\Exception $e) {
            $this->assertStringContainsString($e->getMessage(), '500 Internal Server Error');
        }
    }

    public function test_url_builds()
    {
        $service = $this->getClient();
        $url = $service->url('test');

        $this->assertIsString($url);
        $this->assertStringEndsWith('test', $url);
    }

    /*
     * Utilities
     */
    private function makeRequest()
    {
        $client = new Client();

        $username = getenv('RG_USERNAME');
        $password = getenv('RG_PASSWORD');
        $auth = getenv('RG_AUTHORIZATION');

        return $client->request('GET', 'http://hiring.rewardgateway.net/list?Authorization=' . $auth,
            ['auth' => [$username, $password]]);
    }

    private function mockConfig()
    {
        config([
            'integrations.reward_gateway.base_url' => 'http://dummy.restapiexample.com/api',
            'integrations.version'                 => 'v1',
            'integrations.format'                  => '%s/%s/%s',
        ]);
    }

    /**
     * @return APIService
     */
    private function getClient()
    {
        $this->mockConfig();

        return new RewardGatewayIntegration();
    }
}
