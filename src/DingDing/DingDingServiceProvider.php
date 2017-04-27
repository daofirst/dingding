<?php
namespace DingDing;

use Illuminate\Support\ServiceProvider;

class DingDingServiceProvider extends ServiceProvider
{

    /**
     * 服务提供者加是否延迟加载.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     *
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/dingding.php' => config_path('dingding.php')
        ], 'config');
    }

    public function register()
    {

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

}