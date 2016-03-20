# baidu-seo-push
百度站长平台主动推送 (laravel package)

## Installation

```sh
composer require hyancat/baidu-seo-push
```

## Usage

1. 添加 service provider `config/app.php`

		HyanCat\BaiduSeoPush\BaiduSeoPushServiceProvider::class
	
2. 添加别名 `config/app.php`（建议）

		'BaiduPush' => HyanCat\BaiduSeoPush\BaiduSeoPushFacade::class
	
3. 调用推送方法，例如：

	```php
	$result = \BaiduPush::push($urls, $site, function ($data) {
		// 成功回调
		\Log::info($data);
	}, function ($error) {
		// 失败回调
		\Log::error($error->message);
	});
	```

## License
MIT.


