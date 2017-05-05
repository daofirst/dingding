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

	protected $corpId;

	protected $corpSecret;

	protected $agentId;

	protected $nonceStr;

	public function __construct(Http $http)
	{
		$this->http = $http;
		$this->corpId = config('dingding.corpid');
		$this->corpSecret = config('dingding.corpsecret');
		$this->agentId = config('dingding.agent_id');
		$this->nonceStr = config('dingding.nonce_str');
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
		$accessToken = $this->http->get(Http::joinPath('/gettoken', [
				'corpid' => $this->corpId,
				'corpsecret' => $this->corpSecret
		]));

		return $accessToken['access_token'];
	}

	/**
	 * 获取ticket
	 * @return mixed
	 * @throws DingDingException
	 */
	public function getJsApiTicket()
	{
		try{
			return Cache::remember('ticket', 60, function(){
				return $this->requestJsApiTicket();
			});
		}catch (DingDingException $e) {
			throw $e;
		}
	}


	/**
	 * 请求ticket
	 * @return Curl
	 * @throws DingDingException
	 */
	public function requestJsApiTicket()
	{
		$accessToken = $this->getAccessToken();
		$response = $this->http->get(Http::joinPath('/get_jsapi_ticket', [
				'access_token' => $accessToken,
				'type' => 'jsapi'
		]));

		return $response['ticket'];
	}

	public function getConfig()
	{
		$corpId = $this->corpId;
		$agentId = $this->agentId;
		$nonceStr = $this->nonceStr;
		$timeStamp = time();
		$url = url()->current();

		$ticket =$this->getJsApiTicket();

		$signature = self::sign($ticket, $nonceStr, $timeStamp, $url);

		$config = array(
				'url' => $url,
				'nonceStr' => $nonceStr,
				'agentId' => $agentId,
				'timeStamp' => $timeStamp,
				'corpId' => $corpId,
				'signature' => $signature);
		return json_encode($config, JSON_UNESCAPED_SLASHES);
	}


	public static function sign($ticket, $nonceStr, $timeStamp, $url)
	{
		$plain = 'jsapi_ticket=' . $ticket .
				'&noncestr=' . $nonceStr .
				'&timestamp=' . $timeStamp .
				'&url=' . $url;
		return sha1($plain);
	}
}