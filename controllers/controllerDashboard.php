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

    class controllerDashboard {
        private $_view;
        private $_session;
        private $_userManager;
        private $_routes;
        
        public function __construct($label, $name, $view, $template, $data){
            if($label == "accountChange"){
                $this->accountChange($name, $view, $template);
            } else if($label == "account"){
                $this->account($name, $view, $template);
            } else if($label == "contact"){
                $this->contact($name, $view, $template);
            } else if($label == "api"){
                $this->api($name, $view, $template, $data);
            }
        }

        private function accountChange($name, $view, $template){
            $this->_userManager = new UsersManager;
            $this->_routes = new Routes;
            $this->_session = new Session;
            if($this->_session->isAuth()){
                if($_POST){
                    $error = 0;

                    if($error == 0){
                        $files = $_FILES['avatarupload']['tmp_name'];
                        if(!empty($files) && trim($files) != ""){
                            $uploaddir = WEBSITE_PATH . 'assets/img/';
                            $uploadfile = $uploaddir . $_FILES['avatarupload']['name'];
                            $ext = pathinfo($_FILES["avatarupload"]["name"], PATHINFO_EXTENSION);
                            if($ext != "php"){
                                if (move_uploaded_file('img/'.$_FILES['avatarupload']['tmp_name'], $uploadfile)) {
                                    $nameDB = $_FILES['avatarupload']['name'];
                                    if(!$this->_userManager->updateAvatar($nameDB, $_SESSION['email'])){
                                        $error = 1;
                                        $this->_view = new View($view, $template);
                                        $this->_view->generate(array("titre" => $name, "alert" => "error while downloading file", "typeAlert" => "error"));
                                    }
                                } else {
                                    $error = 1;
                                    $this->_view = new View($view, $template);
                                    $this->_view->generate(array("titre" => $name, "alert" => "error while downloading file", "typeAlert" => "error"));
                                }
                            } else {
                                $error = 1;
                                $this->_view = new View($view, $template);
                                $this->_view->generate(array("titre" => $name, "alert" => "error while downloading file", "typeAlert" => "error"));
                            }
                        }
                    }
                    if($error == 0 && isset($_POST['avatarlink']) && !empty($_POST['avatarlink'])){
                        $avatarpiece = explode("/", $_POST['avatarlink']);
                        $uploaddir = WEBSITE_PATH . 'assets/img/';
                        $img = $uploaddir . end($avatarpiece);
                        file_put_contents($img, file_get_contents($_POST['avatarlink']));
                        if(!$this->_userManager->updateAvatar('img/'.end($avatarpiece), $_SESSION['email'])){
                            $error = 1;
                            $this->_view = new View($view, $template);
                            $this->_view->generate(array("titre" => $name, "alert" => "error while downloading file", "typeAlert" => "error"));
                        }
                    }

                    if($error == 0){
                        $files = $_FILES['proveupload']['tmp_name'];
                        if(!empty($files) && trim($files) != ""){
                            $uploaddir = WEBSITE_PATH . 'assets/img/';
                            $uploadfile = $uploaddir . $_FILES['proveupload']['name'];
                            echo $uploadfile;
                            $ext = pathinfo($_FILES["proveupload"]["name"], PATHINFO_EXTENSION);
                            if($ext != "php"){
                                if (move_uploaded_file($_FILES['proveupload']['tmp_name'], $uploadfile)) {
                                    if(!$this->_userManager->updateProve('img/'.$_FILES['proveupload']['name'], $_SESSION['email'])){
                                        $error = 1;
                                        $this->_view = new View($view, $template);
                                        $this->_view->generate(array("titre" => $name, "alert" => "error while downloading file", "typeAlert" => "error"));
                                    }
                                } else {
                                    $error = 1;
                                    $this->_view = new View($view, $template);
                                    $this->_view->generate(array("titre" => $name, "alert" => "error while downloading file", "typeAlert" => "error"));
                                }
                            } else {
                                $error = 1;
                                $this->_view = new View($view, $template);
                                $this->_view->generate(array("titre" => $name, "alert" => "error while downloading file", "typeAlert" => "error"));
                            }
                        }
                    }
                    if($error == 0 && isset($_POST['provelink']) && !empty($_POST['provelink'])){
                        $provepiece = explode("/", $_POST['provelink']);
                        $uploaddir = WEBSITE_PATH . 'assets/img/';
                        $img = $uploaddir . end($provepiece);
                        file_put_contents($img, file_get_contents($_POST['provelink']));
                        if(!$this->_userManager->updateProve('img/'.end($provepiece), $_SESSION['email'])){
                            $error = 1;
                            $this->_view = new View($view, $template);
                            $this->_view->generate(array("titre" => $name, "alert" => "error while downloading file", "typeAlert" => "error"));
                        }
                    }

                    if($error == 0 && isset($_POST['description']) && !empty($_POST['description'])){
                        if(!$this->_userManager->updateDescription($_POST['description'], $_SESSION['email'])){
                            $error = 1;
                            $this->_view = new View($view, $template);
                            $this->_view->generate(array("titre" => $name, "alert" => "error while updating description", "typeAlert" => "error"));
                        }
                    }

                    if($error == 0 && isset($_POST['password']) && isset($_POST['cpassword']) && !empty($_POST['password']) && !empty($_POST['cpassword'])){
                        if($_POST['password'] == $_POST['cpassword']){
                            if(!$this->_userManager->updatePassword($_POST['password'], $_SESSION['email'])){
                                $error = 1;
                                $this->_view = new View($view, $template);
                                $this->_view->generate(array("titre" => $name, "alert" => "error while updating password", "typeAlert" => "error"));
                            }
                        } else {
                            $error = 1;
                            $this->_view = new View($view, $template);
                            $this->_view->generate(array("titre" => $name, "alert" => "error while updating password", "typeAlert" => "error"));
                        }
                    }

                    if($error == 0){
                        $this->_view = new View($view, $template);
                        $this->_view->generate(array("titre" => $name, "alert" => "account updated", "typeAlert" => "success"));
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

        private function account($name, $view, $template){
            $this->_session = new Session;
            $this->_routes = new Routes;
            $this->_userManager = new UsersManager;
            if($this->_session->isAuth()){
                $users = $this->_userManager->getUsers();
                $this->_view = new View($view, $template);
                $this->_view->generate(array("titre" => $name, "users" => $users));
            } else {
                $_SESSION['alert'] = 'You have been disconnected.';
                $_SESSION['typeAlert'] = 'error';
                header('Location: ' . $this->_routes->url('login'));
            }
        }

        private function contact($name, $view, $template){
            $this->_routes = new Routes;
            $this->_userManager = new UsersManager;
            $this->_session = new Session;
            if($this->_session->isAuth()){
                if($_POST){
                    if(isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['message']) && !empty($_POST['message'])){
                        if($this->_userManager->insertContact($_POST['name'], $_POST['email'], $_POST['message'])){
                            $_SESSION['alert'] = 'Your message has been saved.';
                            $_SESSION['typeAlert'] = 'success';
                            header('Location: ' . $this->_routes->url('account'));
                        } else {
                            $_SESSION['alert'] = 'An error occurred while processing your request.';
                            $_SESSION['typeAlert'] = 'error';
                            header('Location: ' . $this->_routes->url('account'));
                        }
                    } else {
                        $_SESSION['alert'] = 'An error occurred while processing your request.';
                        $_SESSION['typeAlert'] = 'error';
                        header('Location: ' . $this->_routes->url('account'));
                    }
                } else {
                    $_SESSION['alert'] = 'An error occurred while processing your request.';
                    $_SESSION['typeAlert'] = 'error';
                    header('Location: ' . $this->_routes->url('account'));
                }
            } else {
                $_SESSION['alert'] = 'You have been disconnected.';
                $_SESSION['typeAlert'] = 'error';
                header('Location: ' . $this->_routes->url('login'));
            }
        }

        private function api($name, $view, $template, $data){
            $this->_routes = new Routes;
            $this->_userManager = new UsersManager;
            $this->_session = new Session;
            if($this->_session->isAuth()){
                $users = $this->_userManager->getUsers();
                $id = (int) $data[1];
                $exist = 0;
                foreach($users as $user){
                    if((int) $user->id() == $id){
                        $exist = 1;
                    }
                }
                if($exist == 1){
                    $this->_view = new View($view, $template);
                    $this->_view->generate(array("titre" => $name, "users" => $users, "id" => $id));
                } else {
                    $_SESSION['alert'] = 'Unknown user';
                    $_SESSION['typeAlert'] = 'error';
                    header('Location: ' . $this->_routes->url('account'));
                }
            }
        }
    }
?>