<?php 
namespace App\Helper;

class Url
{

	public static function redirect($location = null)
	{
		if ($location) {
			if (!headers_sent()) {
				header('Location: ' . $location);
				exit;
			} else {
				echo '<script type="text/javascript">';
				echo 'window.location.href="' . $location . '";';
				echo '</script>';
				echo '<noscript>';
				echo '<meta http-equiv="refresh" content="0;url=' . $location . '" />';
				echo '</noscript>';
				exit;
			}
		}
	}

	public static function redirectBack()
	{
		header('Location: javascript://history.go(-1)');
		exit;
	}
	
	public static function getPrevious(){
		return $_SERVER['HTTP_REFERER'];
	}

	public static function getRoot($exclude_path = '')
	{
		return self::getTransferProtocol() . self::getHost() . str_replace($exclude_path, '', dirname($_SERVER['SCRIPT_NAME']));
	}

	public static function get()
	{
		return self::getTransferProtocol() . self::getHost() . self::getUri();
	}

	public static function getError()
	{
		return http_response_code();
	}
	
	public static function setError($code)
	{
		return http_response_code($code);
	}

	public static function setHeader($error, $phrase)
	{
		return header(self::getServerProtocol() . " $error $phrase");
	}

	public static function getUri()
	{
		return $_SERVER['REQUEST_URI'];
	}

	public static function getHost()
	{
		return $_SERVER['HTTP_HOST'];
	}

	public static function getServerProtocol()
	{
		return $_SERVER['SERVER_PROTOCOL'];
	}

	public static function getTransferProtocol()
	{
		$isSecure = false;
		if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
			$isSecure = true;
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] ==
			'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] ==
			'on') {
			$isSecure = true;
		}
		return $isSecure ? 'https://' : 'http://';
	}
}
