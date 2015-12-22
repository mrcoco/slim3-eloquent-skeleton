<?php
namespace App\Helper;
use \Slim\Http\Response as Response;
use \App\Model\User;
use \App\Model\UserPermission;
/**
* 
*/
class Acl
{
	private $session;
	private $response;

	public function __construct()
	{
		$this->session = new \App\Helper\Session;
		$this->response = new Response;
	}

	public function profile()
	{
		$user = User::find($this->session->get('user_id'));
		return $user;
	}
	
	public function isAllow($page,$action)
	{
		$user_perm = UserPermission::where('page',$page)->where('action',$action)->where('group_id',$this->session->get('group_id'))->get();
		return $user_perm->toArray();
		
	}
}