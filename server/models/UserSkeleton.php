<?php

    class UserSkeleton
    {
        private $id;

        private $full_name;

        private $email;

        private $password_hash;

        public function __construct($id=null, $full_name, $email, $password_hash) {
            $this->id = $id;
            $this->full_name = $full_name;
            $this->email=$email;
            $this->password_hash=$password_hash;
        }
    
        public function getId() 
        { 
            return $this->id; 
        }

        public function getName()
        {
            return $this->full_name;
        }
        public function getEmail()
        {
            return $this->email;
        }
        public function getPassword()
        {
            return $this->password_hash;
        }
        public function setName($full_name)
        {
            $this->full_name = $full_name;
        }
    
        public function setEmail($email)
        {
            $this->email = $email;
        }
    
        public function setPassword($password_hash)
        {
            $this->password_hash = $password_hash;
        }

    }
?>