<?php
namespace DingDing\Providers;

use Illuminate\Support\ServiceProvider;

class DingDingServiceProvider extends ServiceProvider
{

    /**
     * 服务提供者加是否延迟加载.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../..//resources/config/dingding.php' => config_path('dingding.php')
        ]);

        $this->mergeConfigFrom(__DIR__ . '/../../..//resources/config/dingding.php', 'dingding');
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