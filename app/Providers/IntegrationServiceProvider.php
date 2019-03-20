<?php

namespace App\Providers;

use App\Integrations\RewardGateway\RewardGatewayIntegration;
use Illuminate\Support\ServiceProvider;
use App\Integrations\Interfaces\IntegrationInterface;


class IntegrationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IntegrationInterface::class, RewardGatewayIntegration::class);
    }
}
