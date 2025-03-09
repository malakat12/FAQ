<?php

    class UserSkeleton
    {

        private $full_name;

        private $email;

        private $pass_hash;

        public function __construct($full_name, $email, $pass_hash) {
            $this->full_name = $full_name;
            $this->email=$email;
            $this->pass_hash=$pass_hash;
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
            return $this->pass_hash;
        }
        public function setName($full_name)
        {
            $this->full_name = $full_name;
        }
    
        public function setEmail($email)
        {
            $this->email = $email;
        }
    
        public function setPassword($pass_hash)
        {
            $this->pass_hash = $pass_hash;
        }

    }
?>