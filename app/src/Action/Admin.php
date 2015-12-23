<?php
namespace App\Action;
use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use \Slim\Http\Response as Response;
use App\Helper\Acl;
/**
* 
*/
class Admin
{
	private $view;
    private $logger;
	public $session;
	public $response;

	public function __construct(Twig $view, LoggerInterface $logger)
	{
		$this->view     = $view;
        $this->logger   = $logger;
		$this->session 	= new \App\Helper\Session;
		$this->response = new Response;
	}

	public function index()
	{
		
		Acl::isAllow('admin','index');
		$this->view->render($this->response, 'admin.twig');
	}

	public function users()
	{
		Acl::isAllow('user','index');
		$this->view->render($this->response, 'user.twig');
	}

	public function userEdit()
	{
		Acl::isAllow('user','edit');
		$this->view->render($this->response, 'form.twig');
	}

	public function userDelete()
	{
		Acl::isAllow('user','delete');
		$this->view->render($this->response, 'admin.twig');
	}

	public function groups()
	{
		Acl::isAllow('group','index');
		$this->view->render($this->response, 'admin.twig');
	}

	public function groupsEdit()
	{
		Acl::isAllow('group','edit')
		$this->view->render($this->response, 'admin.twig');
	}
	public function groupsDelete()
	{
		Acl::isAllow('group','delete')
		$this->view->render($this->response, 'admin.twig');
	}

	public function permissions()
	{
		Acl::isAllow('permission','index')
		$this->view->render($this->response, 'admin.twig');
	}

	public function permissionsEdit()
	{
		Acl::isAllow('permission','edit')
		$this->view->render($this->response, 'admin.twig');
	}

	public function permissionsDelete()
	{
		Acl::isAllow('permission','delete')
		$this->view->render($this->response, 'admin.twig');
	}
}