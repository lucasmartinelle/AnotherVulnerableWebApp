<?php
    namespace Model\Tables;

    class Contact {
        // Variables de la table User
        private $_id;
        private $_name;
        private $_email;
        private $_message;

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

        private function setName($name){
            if(is_string($name)){
                $this->_name = $name;
            }
        }

        private function setEmail($email){
            $this->_email = $email;
        }

        private function setMessage($message){
            $this->_message = $message;
        }

        // GETTERS
        public function id(){
            return $this->_id;
        }

        public function name(){
            return $this->_name;
        }

        public function email(){
            return $this->_email;
        }

        public function message(){
            return $this->_message;
        }
    }
?>