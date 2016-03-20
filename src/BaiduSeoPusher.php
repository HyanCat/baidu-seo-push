<?php

namespace HyanCat\BaiduSeoPush;

class BaiduSeoPusher
{
	const API_PUSH = 'http://data.zz.baidu.com/urls?site=%s&token=%s&type=%s';
	const API_UPDATE = 'http://data.zz.baidu.com/update?site=%s&token=%s';
	const API_DELETE = 'http://data.zz.baidu.com/del?site=%s&token=%s';

	protected $token;

	public function __construct($token)
	{
		$this->token = $token;
	}

	/**
	 * 推送 url 列表
	 * @param string|array  $urls
	 * @param string        $site
	 * @param \Closure|null $success
	 * @param \Closure|null $failure
	 * @return string|bool
	 */
	public function push($urls, $site = '', \Closure $success = null, \Closure $failure = null)
	{
		if (! is_array($urls)) {
			$urls = [$urls];
		}
		if (empty($urls)) {
			return false;
		}
		if (empty($site)) {
			$site = parse_url($urls[0])['host'];
		}
		$api = sprintf(self::API_PUSH, $site, $this->token, 'original');

		$result = $this->_execute($api, $urls, $success, $failure);


		return $result;
	}

	/**
	 * 更新 url 列表
	 * @param string|array  $urls
	 * @param string        $site
	 * @param \Closure|null $success
	 * @param \Closure|null $failure
	 * @return string|bool
	 */
	public function update($urls, $site = '', \Closure $success = null, \Closure $failure = null)
	{
		if (! is_array($urls)) {
			$urls = [$urls];
		}
		if (empty($urls)) {
			return false;
		}
		if (empty($site)) {
			$site = parse_url($urls[0])['host'];
		}
		$api = sprintf(self::API_UPDATE, $site, $this->token);

		return $this->_execute($api, $urls, $success, $failure);
	}

	/**
	 * 删除 url 列表
	 * @param string|array  $urls
	 * @param string        $site
	 * @param \Closure|null $success
	 * @param \Closure|null $failure
	 * @return string|bool
	 */
	public function delete($urls, $site = '', \Closure $success = null, \Closure $failure = null)
	{
		if (! is_array($urls)) {
			$urls = [$urls];
		}
		if (empty($urls)) {
			return false;
		}
		if (empty($site)) {
			$site = parse_url($urls[0])['host'];
		}
		$api = sprintf(self::API_DELETE, $site, $this->token);

		return $this->_execute($api, $urls, $success, $failure);
	}

	private function _execute($api, $urls, \Closure $success = null, \Closure $failure = null)
	{
		$ch = curl_init();

		$options = [
			CURLOPT_URL            => $api,
			CURLOPT_POST           => true,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POSTFIELDS     => implode("\n", $urls),
			CURLOPT_HTTPHEADER     => array('Content-Type: text/plain'),
		];
		curl_setopt_array($ch, $options);
		$response = curl_exec($ch);

		if ($response) {
			$data = json_decode($response, true);
			if (array_key_exists('success', $data) && $success) {
				call_user_func($success, $data);
			}
			if (array_key_exists('error', $data) && $failure) {
				$error          = new \stdClass();
				$error->code    = $data['error'];
				$error->message = $data['message'];
				call_user_func($failure, $error);
			}
		}
		elseif ($failure) {
			$error          = new \stdClass();
			$error->code    = -1;
			$error->message = 'curl failed.';
			call_user_func($failure, $error);
		}

		return $response;
	}
}
