<?php
namespace DingDing\Eloquent;

use Curl\Curl;
use DingDing\Contracts\AuthInterface;
use \Cache;
use DingDing\Exceptions\DingDingException;
use DingDing\Util\Http;

class Auth implements AuthInterface {

	/**
	 * @var Http
	 */
	protected $http;

	public function __construct(Http $http)
	{
		$this->http = $http;
	}

	/**
	 * 获取AccessToken
	 */
	public function getAccessToken(){
		try{
			return Cache::remember('access_token', 60, function(){
				return $this->requestAccessToken();
			});
		}catch (DingDingException $e) {
			throw $e;
		}
	}

	/**
	 * 请求AccessToken
	 * @return Curl
	 * @throws DingDingException
	 */
	public function requestAccessToken()
	{

		$corpId = config('dingding.corpid');
		$corpSecret = config('dingding.corpsecret');
		$accessToken = $this->http->get(Http::joinPath('/gettoken', [
				'corpid' => $corpId,
				'corpsecret' => $corpSecret
		]));

		if ($accessToken->error)
		{
			throw new DingDingException($accessToken->error_message, $accessToken->error_code);
		}

		return json_decode($accessToken->response)->access_token;
	}
}