<?php
    namespace Models;

    require_once("models/Model.php");
    require_once("utils/Session.php");
    use Models\Model;
    use Utils\Session;

    use PDO;

    class UsersManager extends Model {
        private $_session;

        public function getUsers(){
            return $this->getAll('users', 'Users');
        }

        public function getContact(){
            return $this->getAll('contact', 'Contact');
        }

        public function all(){
            return $this->select('users', null, null, null);
        }

        public function updateToken($token, $email){
            if(filter_var($token, FILTER_SANITIZE_STRING)){
                $this->update('users', array('token' => $token), array('email' => $email));
            }
        }

        public function changePassword($token, $password, $email){
            return $this->update('users', array('token' => $token, 'password' => $password), array('email' => $email));
        }

        public function newUser($data){
            return $this->insert('users', $data);
        }

        public function deleteUsers($id){
            return $this->delete("users", array("id" => $id));
        }

        public function amountUser(){
            $users = $this->select('users', null, null, null);
            $count = 0;
            while($row = $users->fetch(PDO::FETCH_ASSOC)){
                $count++;
            }
            return $count;
        }

        public function validUser($email){
            $this->_session = new Session;
            $date = date('Y-m-d H:i:s');
            $token = $this->_session->updateToken();
            return $this->update('users', array('validity' => 'on', 'updated_at' => $date, 'token' => $token), array('email' => $email));
        }

        public function infoUser($data){
            return $this->select("users", $data, null, null);
        }

        public function getRegistration(){
            $activeDB = $this->select("registration", null, null, null);
            while($active = $activeDB->fetch(PDO::FETCH_ASSOC)){
                if($active['active'] == 'on'){
                    return true;
                }
            }
            return false;
        }

        public function updateAvatar($avatar, $email){
            return $this->update('users', array('avatar' => $avatar), array("email" => $email));
        }

        public function updateProve($prove, $email){
            return $this->update('users', array('identity' => $prove), array("email" => $email));
        }

        public function updateDescription($description, $email){
            return $this->update('users', array('description' => $description), array('email' => $email));
        }

        public function updatePassword($password, $email){
            return $this->update('users', array('password' => $password), array('email' => $email));
        }

        public function insertContact($name, $email, $message){
            return $this->insert('contact', array('name' => $name, 'email' => $email, 'message' => $message));
        }

        public function registration($state, $registration){
            if($state){
                if($registration){
                    return true;
                } else {
                    return $this->update('registration', array("active" => 'on'), array('active' => 'off'));
                }
            } else {
                if($registration){
                    return $this->update('registration', array("active" => 'off'), array('active' => 'on'));
                } else {
                    return true;
                }
            }
        }
    }
?>