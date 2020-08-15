<?php
    namespace Utils;

    require_once("models/UsersManager.php");
    use Models\UsersManager;

    class Session {
        private $_userManager;

        // Check if user is authenticate or not
        public function isAuth(){
            $this->_userManager = new UsersManager;
            $auth = false;
            $username;
            $email;
            $password;
            if (isset($_SESSION['username']) AND !empty($_SESSION['username']) AND isset($_SESSION['email']) AND !empty($_SESSION['email']) AND isset($_SESSION['password']) AND !empty($_SESSION['password'])) {
                $username = htmlspecialchars($_SESSION['username'], ENT_QUOTES);
                $email = htmlspecialchars($_SESSION['email'], ENT_QUOTES);
                $password = htmlspecialchars($_SESSION['password'], ENT_QUOTES);
                $auth = true;
            }
        
            if (isset($_COOKIE['username']) AND !empty($_COOKIE['username']) AND isset($_COOKIE['email']) AND !empty($_COOKIE['email']) AND isset($_COOKIE['password']) AND !empty($_COOKIE['password'])) {
                $username = htmlspecialchars($_COOKIE['username'], ENT_QUOTES);
                $email = htmlspecialchars($_COOKIE['email'], ENT_QUOTES);
                $password = htmlspecialchars($_COOKIE['password'], ENT_QUOTES);
                $auth = true;
            }
            if($auth == true){
                $users = $this->_userManager->getUsers();
                foreach($users as $user){
                    if($user->username() == $username && $user->email() == $email && $user->password() == $password){
                        $_SESSION['role'] = $user->role();
                        $_SESSION['id'] = $user->id();
                        $token = bin2hex(openssl_random_pseudo_bytes(16));
                        $_SESSION['token'] = $token;
                        $this->_userManager->updateToken($token, $email);
                        return true;
                    }
                }
            }
            return false;
        }

        // Authenticate user if he is in users table
        public function Auth($email, $rem){
            $this->_userManager = new UsersManager;
            $users = $this->_userManager->getUsers();
            foreach($users as $user){
                if($user->email() == $email){
                    if($rem == 'on'){
                        setcookie('username', $user->username(), time() + (86400 * 30), "/");
                        setcookie('email', $user->email(), time() + (86400 * 30), "/");
                        setcookie('password', $user->password(), time() + (86400 * 30), "/");
                    } else {
                        $_SESSION['username'] = $user->username();
                        $_SESSION['email'] = $user->email();
                        $_SESSION['password'] = $user->password();
                    }
                    $this->isAuth();
                    return true;
                }
            }
            return false;
        }

        public function disconnect(){
            if (isset($_SESSION['username']) AND !empty($_SESSION['username']) AND isset($_SESSION['email']) AND !empty($_SESSION['email']) AND isset($_SESSION['password']) AND !empty($_SESSION['password'])) {
                $_SESSION['username'] = '';
                $_SESSION['email'] = '';
                $_SESSION['password'] = '';
                if(isset($_SESSION['role']) && !empty($_SESSION['role'])){
                    $_SESSION['role'] = '';
                }
                session_regenerate_id();
                return true;
            }
        
            if (isset($_COOKIE['username']) AND !empty($_COOKIE['username']) AND isset($_COOKIE['email']) AND !empty($_COOKIE['email']) AND isset($_COOKIE['password']) AND !empty($_COOKIE['password'])) {
                setcookie('username', '', time() - (86400 * 30), "/");
                setcookie('email', '', time() - (86400 * 30), "/");
                setcookie('password', '', time() - (86400 * 30), "/");
                if(isset($_SESSION['role']) && !empty($_SESSION['role'])){
                    $_SESSION['role'] = '';
                }
                return true;
            }
            return false;
        }

        public function updateToken(){
            $this->_userManager = new UsersManager;
            if($this->isAuth()){
                $token = $_SESSION['token'];
                $email = htmlspecialchars($_SESSION['email'], ENT_QUOTES);
                $this->_userManager->updateToken($token, $email);
                return $token;
            } else {
                $token = bin2hex(openssl_random_pseudo_bytes(16));
                $_SESSION['token'] = $token;
                return $token;
            }
            return $token;
        }

        public function getToken(){
            return htmlspecialchars($_SESSION['token'], ENT_QUOTES);
        }

        public function isAdmin(){
            if(isset($_SESSION['role']) && !empty($_SESSION['role'])){
                if($_SESSION['role'] == 'administrator'){
                    return true;
                }
            }
            return false;
        }
    }
?>