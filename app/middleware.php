<?php
use Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware;
use \App\Helper\Acl;

$app->add(new WhoopsMiddleware);
$app->add(function($request, $response, $next){
	$acl = new Acl; 
	switch ($request->getUri()->getPath()) {
		case '/':
			break;
		case '/login':
			$response->write(' Please Insert Username and password ');
			break;
		case '/register':
			$response->write(' Please Insert all field ');
			break;
		case '/logout':
			$response->write(' logout ');
			break;
		case '/dashboard':
			$response->write(' dashboard ');
			break;
		default:
			$routes = $acl->getRoute($request->getUri()->getPath());
			if(! $routes->count() == 0){
				if(! $acl->cekPermission($routes->page,$routes->action)){
					return $this->view->render($response, 'dashboard.twig',['flash' => 'You dont have permission to access '.$request->getUri()->getPath() ] );
				} 
			}else{
				return $this->view->render($response, 'dashboard.twig',['flash' => 'You dont have permission to access, '.$request->getUri()->getPath().' page not found' ] );
			}
			break;
	}
	
	$response = $next($request, $response);
	return $response;
});
