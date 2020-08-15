<?php
    namespace controllers;

    require_once("views/View.php");
    require_once("models/UsersManager.php");
    require_once("utils/Session.php");
    require_once("app/Routes.php");
    require_once("utils/Sender.php");
    
    use app\Routes;
    use Utils\Session;
    use Models\UsersManager;
    use view\View;
    use Utils\Sender;

    class controllerAuth {
        private $_view;
        private $_session;
        private $_userManager;
        private $_routes;
        private $_sender;
        
        public function __construct($label, $name, $view, $template, $data){
            if($label == "login"){
                $this->login($name, $view, $template);
            } else if($label == "register"){
                $this->register($name, $view, $template);
            } else if($label == "forgot"){
                $this->forgot($name, $view, $template);
            } else if($label == "logout"){
                $this->logout();
            } else if($label == "validation"){
                $this->validation($name, $view, $template, $data);
            }
        }

        private function login($name, $view, $template){
            $this->_userManager = new UsersManager;
            $this->_session = new Session;
            $this->_routes = new Routes;
            if($_POST){
                if(isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])){
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $emailExist = 0;
                    $passwordMatch = 0;
                    $users = $this->_userManager->getUsers();
                    foreach($users as $user){
                        if($user->email() == $email){
                            $emailExist = 1;
                            if($password == $user->password()){
                                $passwordMatch = 1;
                            }
                        }
                    }
                    if($emailExist == 1){
                        if($passwordMatch == 1){
                            $this->_session->Auth($email, 'off');
                            header('Location: ' . $this->_routes->url("account"));
                        } else {
                            $this->_view = new View($view, $template);
                            $this->_view->generate(array("alert" => "User or password incorrect", "typeAlert" => "error", "titre" => $name));
                        }
                    } else {
                        $this->_view = new View($view, $template);
                        $this->_view->generate(array("alert" => "Unknown user", "typeAlert" => "error", "titre" => $name));
                    }
                } else {
                    $this->_view = new View($view, $template);
                    $this->_view->generate(array("alert" => "Fields are invalid", "typeAlert" => "error", "titre" => $name));
                }
            } else {
                $this->_view = new View($view, $template);
                $this->_view->generate(array("titre" => $name));
            }
        }

        private function register($name, $view, $template){
            $this->_userManager = new UsersManager;
            $this->_session = new Session;
            if($_POST){
                if(isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['cpassword']) && !empty($_POST['cpassword'])){
                    $username = $_POST['username'];
                    $email = $_POST['email'];
                    $users = $this->_userManager->getUsers();
                    $continue = 1;
                    foreach($users as $user){
                        if($user->email() == $email){
                            $continue = 0;
                            $this->_view = new View($view, $template);
                            $this->_view->generate(array("alert" => "This email address has already been taken.", "typeAlert" => "error", "titre" => $name));
                        }
                    }
                    if($continue == 1){
                        $password = $_POST['password'];
                        $role;
                        $count = $this->_userManager->amountUser();
                        $apiKey = bin2hex(openssl_random_pseudo_bytes(4));
                        if($count < 2){
                            $role = "administrator";
                        } else {
                            $role = "user";
                        }
                        $token = $this->_session->updateToken();
                        if($this->_userManager->newUser(array('username' => $username, 'email' => $email, 'password' => $password, 'validity' => 'on', 'token' => $token, 'role' => $role, 'APIKey' => $apiKey))) {
                            $this->_view = new View($view, $template);
                            $this->_view->generate(array("alert" => "Your registration is complete, you can now logging in.", "typeAlert" => "success", "titre" => $name));
                        } else {
                            $this->_view = new View($view, $template);
                            $this->_view->generate(array("alert" => "An error has occurred while processing your request.", "typeAlert" => "error", "titre" => $name));
                        }
                    }
                } else {
                    $this->_view = new View($view, $template);
                    $this->_view->generate(array("alert" => "Fields are invalid", "typeAlert" => "error", "titre" => $name));
                }
            } else {
                $this->_view = new View($view, $template);
                $this->_view->generate(array("titre" => $name));
            }
        }

        private function forgot($name, $view, $template){
            $this->_userManager = new UsersManager;
            $this->_session = new Session;
            $this->_routes = new Routes;
            if(isset($_POST['email']) && !empty($_POST['email'])){
                $users = $this->_userManager->getUsers();
                $continue = 0;
                foreach($users as $user){
                    if($user->email() == $_POST['email']){
                        $continue = 1;
                    }
                }
                if($continue == 1){
                    $token = $this->_session->updateToken();
                    $forgotURL = $this->_routes->urlReplace("validation", array($token));
                    $this->_sender = new Sender(null, $_POST['email'], $forgotURL);
                    if($this->_sender->resetpassword()){
                        $this->_userManager->updateToken($token, $_POST['email']);
                        $this->_view = new View($view, $template);
                        $this->_view->generate(array("alert" => "If the email exists, an email will be sent to you to allow you to change your password.", "typeAlert" => "success", "titre" => $name));
                    } else {
                        $this->_view = new View($view, $template);
                        $this->_view->generate(array("alert" => "An error has occurred while processing your request.", "typeAlert" => "success", "titre" => $name));
                    }
                } else {
                    $this->_view = new View($view, $template);
                    $this->_view->generate(array("alert" => "This email address is unknown.", "typeAlert" => "error", "titre" => $name));
                }

            }
            $this->_view = new View($view, $template);
            $this->_view->generate(array("titre" => $name));
        }

        private function validation($name, $view, $template, $data){
            $token = $data[2];
            $this->_routes = new Routes;
            $this->_userManager = new UsersManager;
            $this->_session = new Session;
            $continue = 0;
            $email;
            if(isset($token) && !empty($token)){
                $users = $this->_userManager->getUsers();
                foreach($users as $user){
                    if($user->token() == $token){
                        $email = $user->email();
                        $continue = 1;
                    }
                }
            }  
            if($continue == 1){
                if($_POST){
                    if(isset($_POST['password']) && isset($_POST['cpassword']) && !empty($_POST['password']) && !empty($_POST['cpassword'])){
                        if($_POST['password'] == $_POST['cpassword']){
                            if(!$this->_userManager->updatePassword($_POST['password'], $email)){
                                $this->_view = new View($view, $template);
                                $this->_view->generate(array("titre" => $name, "alert" => "error while updating password", "typeAlert" => "error"));
                            } else {
                                $_SESSION['alert'] = 'Your password has been changed.';
                                $_SESSION['typeAlert'] = 'success';
                                header('Location: ' . $this->_routes->url('login'));
                            }
                        } else {
                            $this->_view = new View($view, $template);
                            $this->_view->generate(array("titre" => $name, "alert" => "error while updating password", "typeAlert" => "error"));
                        }
                    }
                } else {
                    $this->_view = new View($view, $template);
                    $this->_view->generate(array("titre" => $name));
                }
            } else {
                header('Location: ' . $this->_routes->url("login"));
            }
        }

        private function logout(){
            $this->_routes = new Routes;
            $this->_session = new Session;
            if($this->_session->isAuth()){
                if($this->_session->disconnect()){
                    $_SESSION['alert'] = 'You have been disconnected';
                    $_SESSION['typeAlert'] = 'error';
                    header('Location: ' . $this->_routes->url("login"));
                } else {
                    header('Location: ' . $this->_routes->url("login"));
                }
            } else {
                $_SESSION['alert'] = 'You have been disconnected';
                $_SESSION['typeAlert'] = 'error';
                header('Location: ' . $this->_routes->url("login"));
            }
        }
    }
?>