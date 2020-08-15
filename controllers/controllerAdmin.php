<?php
    namespace controllers;

    require_once("views/View.php");
    require_once("models/UsersManager.php");
    require_once("utils/Session.php");
    require_once("app/Routes.php");
    
    use app\Routes;
    use Utils\Session;
    use Models\UsersManager;
    use view\View;

    class controllerAdmin {
        private $_view;
        private $_session;
        private $_userManager;
        private $_routes;
        
        public function __construct($label, $name, $view, $template, $data){
            if($label == "adminLogin"){
                $this->adminLogin($name, $view, $template);
            } else if($label == "admin"){
                $this->admin($name, $view, $template);
            }
        }

        private function adminLogin($name, $view, $template){
            $this->_userManager = new UsersManager;
            $this->_routes = new Routes;
            $this->_session = new Session;
            if($this->_session->isAuth()){
                if($_POST){
                    if(isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password'])){
                        if($_POST['username'] == IDENTIFIANT_ADMIN && $_POST['password'] == PASSWORD_ADMIN){
                            $_SESSION['adminLogin'] = IDENTIFIANT_ADMIN;
                            $_SESSION['adminPassword'] = PASSWORD_ADMIN;
                            header('Location: ' . $this->_routes->url('admin'));
                        } else {
                            $this->_view = new View($view, $template);
                            $this->_view->generate(array("titre" => $name, "alert" => "Incorrect user or password.", "typeAlert" => "error"));
                            $_SESSION['adminLogin'] = "";
                            $_SESSION['adminPassword'] = "";
                        }
                    } else {
                        $this->_view = new View($view, $template);
                        $this->_view->generate(array("titre" => $name, "alert" => "An error occurred while processing your request.", "typeAlert" => "error"));
                        $_SESSION['adminLogin'] = "";
                        $_SESSION['adminPassword'] = "";
                    }
                } else {
                    $this->_view = new View($view, $template);
                    $this->_view->generate(array("titre" => $name));
                } 
            } else {
                $_SESSION['alert'] = 'You have been disconnected.';
                $_SESSION['typeAlert'] = 'error';
                header('Location: ' . $this->_routes->url('login'));
            }
        }

        private function admin($name, $view, $template){
            $this->_userManager = new UsersManager;
            $this->_routes = new Routes;
            $this->_session = new Session;
            if($_SESSION['adminLogin'] == "Administrator" && $_SESSION['adminPassword'] == "password123"){
                if($this->_session->isAuth()){
                    $message = $this->_userManager->getContact();
                    $this->_view = new View($view, $template);
                    $this->_view->generate(array("titre" => $name, "contact" => $message));
                } else {
                    $_SESSION['alert'] = 'You have been disconnected.';
                    $_SESSION['typeAlert'] = 'error';
                    header('Location: ' . $this->_routes->url('login'));
                }
            } else {
                if($this->_session->isAuth()){
                    header('Location: ' . $this->_routes->url('adminLogin'));
                } else {
                    $_SESSION['alert'] = 'You have been disconnected.';
                    $_SESSION['typeAlert'] = 'error';
                    header('Location: ' . $this->_routes->url('login'));
                }
            }
        }
    }
?>