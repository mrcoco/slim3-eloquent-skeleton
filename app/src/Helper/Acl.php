<?php
namespace App\Helper;
use \App\Model\User;
use \App\Model\UserPermission;
use App\Helper\Url;
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
		if(empty($user_perm->toArray())){
			$this->session->set('flash','You dont have permission ');
			return Url::redirect($location='dashboard');
		}
		
	}
}