<?php
namespace App\Action;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Carlosocarvalho\SimpleInput\Input\Input;
use App\Model\User;
use App\Validation\Validator;
use App\Helper\Hash;
use App\Helper\Acl;
use App\Helper\JsonRequest;
use App\Helper\JsonRenderer;

final class HomeAction
{
    private $view;
    private $logger;
    private $hash;
    private $auth;
    private $session;
    private $jsonRequest;

    public function __construct(JsonRequest $jsonRequest,Twig $view, LoggerInterface $logger, $hash,$auth)
    {
        $this->view     = $view;
        $this->logger   = $logger;
        $this->hash     = $hash;
        $this->auth     = $auth;
        $this->session  = new \App\Helper\Session;
        $this->jsonRequest  = new JsonRequest();
        $this->JsonRender   = new JsonRenderer();
       
    }

    public function dispatch(Request $request, Response $response, $args)
    {
        $this->logger->info("Home page action dispatched");
        
        $this->view->render($response, 'home.twig',[
            'user' => User::all(),
            
            ]);
        return $response;
    }

    public function dashboard(Request $request, Response $response, $args)
    {
        $flash = $this->session->get('flash');
        return $this->view->render($response, 'dashboard.twig',['flash' => $flash ] );
    }

    public function logout(Request $request, Response $response, $args)
    {
        $session    = new \App\Helper\Session;
        $session::destroy();
        return $response->withRedirect('login');
    }

    public function login(Request $request, Response $response, $args){
        $this->view->render($response, 'login.twig',
            ['csrf' => [
                        'name' => $request->getAttribute('csrf_name'),
                        'value' => $request->getAttribute('csrf_value'),
                      ],
            ]);
        return $response;
    }

    public function testJson(Request $request, Response $response, $args)
    {
        $jsonRequest = $this->jsonRequest->setRequest($request);

        $user_id = $jsonRequest->getRequestParam('password');

           $data = [
                'user_id' => $user_id
            ];

            $response = $this->JsonRender->render($response, 200, $data);
            return $response;
    }

    public function loginPost(Request $request, Response $response, $args)
    {
        $identifier = Input::post('identifier');
        $password   = Input::post('password');
        $v = new Validator(new User);
        $v->validate([
        'identifier'    => [$identifier, 'required|email'],
        'password'      => [$password, 'required']
        ]);;
        if ($request->getAttribute('csrf_status') === false) {
            $flash = 'CSRF faiure';
            $this->view->render($response, 'login.twig',['errors' => $v->errors(),'flash' => $flash,'request' => $request]);
        }else{
            if($v->passes()){            
                $user = User::where('username', $identifier)->orWhere('email', $identifier)->first();
                if($user && $this->hash->passwordCheck($password, $user->password)){                
                    $this->session->set($this->auth['session'],$user->id);
                    $this->session->set($this->auth['group'],$user->group_id);
                    return $response->withRedirect('dashboard');
                }
                else{
                    $flash = 'Sorry, you couldn\'t be logged in.';            
                    $this->view->render($response, 'login.twig',['errors' => $v->errors(),'flash' => $flash,'request' => $request]);
                }

            }else{        
                $this->view->render($response, 'login.twig',
                    ['errors' => $v->errors(),
                    'request' => $request,
                    'csrf' => [
                        'name' => $request->getAttribute('csrf_name'),
                        'value' => $request->getAttribute('csrf_value'),
                      ],
                    ]);
            }
        }
        
        return $response;
    }

    public function register(Request $request, Response $response, $args)
    {
        $this->view->render($response, 'register.twig');
        return $response;
    }

    public function registerPost(Request $request, Response $response, $args)
    {
        $email      = Input::post('email');
        $username   = Input::post('username');
        $password   = Input::post('password');

        $passwordConfirm = Input::post('password_confirm');
        $v = new Validator(new User);
        $v->validate([
            'email'     => [$email, 'required|email|uniqueEmail'],
            'username'  => [$username, 'required|alnumDash|max(20)|uniqueUsername'],
            'password'  => [$password, 'required|min(6)'],
            'password_confirm' => [$passwordConfirm, 'required|matches(password)']
        ]);

        if ($v->passes()) {
            $user = new User();
            $user->email    = $email;
            $user->username = $username;
            $user->password = $this->hash->password($password);
            $user->group_id = 3;
            $user->save();
            $flash = "You have been registered.";
        }else{
            $flash = "registration failed.";
        }
        
        $this->view->render($response, 'register.twig',['errors' => $v->errors(),'flash' => $flash,'request' => $request]);
        return $response;
    }
}
