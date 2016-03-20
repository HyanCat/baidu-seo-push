<?php
namespace HyanCat\BaiduSeoPush;

use Illuminate\Support\ServiceProvider;

class BaiduSeoPushServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bindShared('baiduseopush', function ($app) {
            return new BaiduSeoPusher;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['baiduseopush'];
    }

}
