<?php

namespace App\Http\Controllers;

//use App\Integrations\Interfaces\IntegrationInterface as Integration;
use App\Integrations\RewardGateway\RewardGatewayIntegration as Integration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class EmployeeController
{
    protected $integration;
    protected $request;
    protected $response;

    public function __construct(
        Integration $integration,
        Request $request,
        Response $response
    ) {
        $this->integration = $integration;
        $this->request = $request;
        $this->response = $response;
    }

    public function index()
    {
        $response = $this->integration->get('list');
        $employees = [];
        $statusCode = 400;

        if ($response) {
            $employees = $this->integration->getPayload($response);
            $statusCode = $response->getStatusCode();
        }

        return response()->json($employees)->setStatusCode($statusCode);

    }
}