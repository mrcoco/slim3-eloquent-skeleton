<?php
namespace App\Middleware;
use App\Helper\Acl;
/**
* 
*/
class AuthMiddleware
{
	
	public $session;

	public function __construct()
	{
		$this->session = new \App\Helper\Session;
	}

	public function __invoke($request, $response, $next)
    {
        //$response->getBody()->write($request);
        // echo "<pre>";
        // print_r($request->getUri()->getPath());
        // echo "</pre>";
        //return Acl::isAllow('admin','index');
        //$response = $next($request, $response);
        return $response->withRedirect('login');
    }
}