<?php
namespace Daofirst\DingDing\Eloquent;

use Daofirst\DingDing\Contracts\AuthInterface;

class Auth implements AuthInterface {

	/**
	 * 获取AccessToken
	 */
	public static function getAccessToken(){
		var_dump('开发钉钉');exit();
	}
}