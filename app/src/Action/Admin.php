<?php
namespace App\Action;
use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
//use \Slim\Http\Response as Responses;
use App\Helper\Acl;
use App\Helper\Session;
/**
* 
*/
class Admin
{
	private $view;
    private $logger;
	public $session;
	public $response;
	public $privateResources; 

	public function __construct(Twig $view, LoggerInterface $logger, Session $session)
	{
		$this->view     = $view;
        $this->logger   = $logger;
		$this->session 	= $session;
	}

	public function index(Request $request, Response $response, $args)
	{
		
		$this->view->render($response, 'admin.twig');
	}

	public function users(Request $request, Response $response, $args)
	{
		
		//Acl::isAllow('user','index');
		$this->view->render($response, 'user.twig');
	}

	public function userEdit(Request $request, Response $response, $args)
	{
		Acl::isAllow('user','edit');
		$this->view->render($response, 'form.twig');
	}

	public function userDelete()
	{
		Acl::isAllow('user','delete');
		$this->view->render($response, 'admin.twig');
	}

	public function groups(Request $request, Response $response, $args)
	{
		Acl::isAllow('group','index');
		$this->view->render($response, 'admin.twig');
	}

	public function groupsEdit(Request $request, Response $response, $args)
	{
		Acl::isAllow('group','edit');
		$this->view->render($response, 'admin.twig');
	}
	public function groupsDelete()
	{
		Acl::isAllow('group','delete');
		$this->view->render($response, 'admin.twig');
	}

	public function permissions(Request $request, Response $response, $args)
	{
		//Acl::isAllow('permission','index');
		$resource 	= Acl::getResource();
		$user 		= Acl::getUser();
		$this->view->render($response, 'admin.twig',['resource' => $resource , 'user' => $user ]);
	}

	public function permissionsEdit(Request $request, Response $response, $args)
	{
		Acl::isAllow('permission','edit');
		$this->view->render($response, 'admin.twig');
	}

	public function permissionsDelete()
	{
		Acl::isAllow('permission','delete');
		$this->view->render($response, 'admin.twig');
	}
}