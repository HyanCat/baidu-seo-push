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
		$this->app->singleton('baiduseopush', function ($app) {
			return new BaiduSeoPusher(config('baidu-seo-push.token'));
		});
	}

	public function boot()
	{
		$this->publishes([
			__DIR__ . '/../config/baidu-seo-push.php' => config_path('baidu-seo-push.php'),
		]);
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
