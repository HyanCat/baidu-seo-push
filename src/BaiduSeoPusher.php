<?php

namespace HyanCat\BaiduSeoPush;

class BaiduSeoPusher
{
	const API_PUSH = 'http://data.zz.baidu.com/urls?site=%s&token=%s';

	protected $token;

	public function __construct($token)
	{
		$this->token = $token;
	}

	/**
	 * 推送 url 列表
	 * @param  string|array $urls
	 * @param  string       $site
	 * @return string|bool
	 */
	public function push($urls, $site = '')
	{
		if (is_string($urls)) {
			$urls = [$urls];
		}
		if (empty($urls)) {
			return false;
		}
		if (empty($site)) {
			$site = parse_url($urls[0])['host'];
		}
		$api = sprintf(self::API_PUSH, $site, $this->token);
		$ch  = curl_init();

		$options = [
			CURLOPT_URL            => $api,
			CURLOPT_POST           => true,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POSTFIELDS     => implode("\n", $urls),
			CURLOPT_HTTPHEADER     => array('Content-Type: text/plain'),
		];
		curl_setopt_array($ch, $options);
		$response = curl_exec($ch);

		return $response;
	}

	public function update()
	{

	}

	public function delete()
	{

	}

}
