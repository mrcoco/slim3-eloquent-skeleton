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
		if(! Acl::isAllow('admin','index')){
			return $this->response->withRedirect('dashboard');
		}
		$this->view->render($this->response, 'admin.twig');
	}
}