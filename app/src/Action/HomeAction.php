<?php
namespace App\Action;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Model\User;
use App\Validation\Validator;
use App\Helper\Hash;
use \Slim\Flash\Messages;
final class HomeAction
{
    private $view;
    private $logger;
    private $hash;
    private $auth;
    private $flash;
    private $app;

    public function __construct(Twig $view, LoggerInterface $logger, $hash,$auth)
    {
        $this->view     = $view;
        $this->logger   = $logger;
        $this->hash     = $hash;
        $this->auth     = $auth;
        $this->flash    = new \Slim\Flash\Messages();
       
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
        if(isset($_SESSION['user_id'])){

        }else{
            return $response->withRedirect('login');
        }
    }

    public function logout(Request $request, Response $response, $args)
    {
        $session    = new \App\Helper\Session;
        $session::destroy();
        return $response->withRedirect('login');
    }

    public function login(Request $request, Response $response, $args){
        $this->view->render($response, 'login.twig');
        return $response;
    }

    public function loginPost(Request $request, Response $response, $args)
    {
        $identifier = $_POST['identifier'];
        $password   = $_POST['password'];
        $v = new Validator(new User);
        $v->validate([
        'identifier'    => [$identifier, 'required|email'],
        'password'      => [$password, 'required']
        ]);;

        if($v->passes()){
            $user = User::where('username', $identifier)->orWhere('email', $identifier)->first();
            if($user && $this->hash->passwordCheck($password, $user->password)){
                $_SESSION[$this->auth['session']] = $user->id;
                return $response->withRedirect('dashboard');
            }
            else{
                $this->flash->addMessage('global', 'Sorry, you couldn\'t be logged in.');            
                $this->view->render($response, 'login.twig',['errors' => $v->errors(),'request' => $request]);
            }

        }else{        
            $this->view->render($response, 'login.twig',['errors' => $v->errors(),'request' => $request]);
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
        $email      = $_POST['email'];
        $username   = $_POST['username'];
        $password   = $_POST['password'];
        $passwordConfirm = $_POST['password_confirm'];
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
            $user->save();
            $success = "You have been registered.";
        }
        
        $this->view->render($response, 'register.twig',['errors' => $v->errors(),'success' => $success,'request' => $request]);
        return $response;
    }
}
