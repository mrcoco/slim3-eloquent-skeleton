<?php
namespace App\Helper;
use \App\Model\User;
use \App\Model\UserPermission;
/**
* 
*/
class Acl
{
	private $session;

	public function __construct()
	{
		$this->session = new \App\Helper\Session;
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