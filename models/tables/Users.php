<?php
    namespace Model\Tables;

    class Users {
        // Variables de la table User
        private $_id;
        private $_username;
        private $_email;
        private $_password;
        private $_token;
        private $_role;
        private $_validity;
        private $_createdat;
        private $_updatedat;
        private $_avatar;
        private $_description;
        private $_identity;
        private $_APIKey;

        // Constructeur de la classe
        public function __construct(array $data){
            $this->hydrate($data);
        }

        // hydratation des variables en passant par les setters
        public function hydrate(array $data){
            foreach($data as $key => $value){
                $method = 'set'.ucfirst($key);
                $method = str_replace('_', '', $method);

                if(method_exists($this, $method)){
                    $this->$method($value);
                }
            }
        }

        // SETTERS
        private function setId($id){
            $id = (int) $id;

            if($id > 0){
                $this->_id = $id;
            }
        }

        private function setUsername($username){
            if(is_string($username)){
                $this->_username = $username;
            }
        }

        private function setEmail($email){
            $this->_email = $email;
        }

        private function setPassword($password){
            if(is_string($password)){
                $this->_password = $password;
            }
        }

        private function setToken($token){
            if(is_string($token)){
                $this->_token = $token;
            }
        }

        private function setRole($role){
            if(is_string($role)){
                $this->_role = $role;
            }
        }

        private function setValidity($validity){
            if(is_string($validity)){
                $this->_validity = $validity;
            }
        }

        private function setCreatedat($createdat){
            $this->_createdat = $createdat;
        }

        private function setUpdatedat($updatedat){
            $this->_updatedat = $updatedat;
        }

        private function setAvatar($avatar){
            if(is_string($avatar)){
                $this->_avatar = $avatar;
            }
        }

        private function setDescription($description){
            if(is_string($description)){
                $this->_description = $description;
            }
        }

        private function setIdentity($identity){
            if(is_string($identity)){
                $this->_identity = $identity;
            }
        }

        private function setAPIKey($apikey){
            $this->_APIKey = $apikey;
        }

        // GETTERS
        public function id(){
            return $this->_id;
        }

        public function username(){
            return $this->_username;
        }

        public function email(){
            return $this->_email;
        }

        public function password(){
            return $this->_password;
        }

        public function token(){
            return $this->_token;
        }

        public function role(){
            return $this->_role;
        }

        public function validity(){
            return $this->_validity;
        }

        public function createdat(){
            return $this->_createdat;
        }

        public function updatedat(){
            return $this->_updatedat;
        }

        public function avatar(){
            return $this->_avatar;
        }

        public function description(){
            return $this->_description;
        }

        public function identity(){
            return $this->_identity;
        }

        public function APIKey(){
            return $this->_APIKey;
        }
    }
?>