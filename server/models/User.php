<?php
    require_once __DIR__ . '/../connection/connect.php';

    class User extends UserSkeleton{

        private $conn;

        public function __construct($conn, $full_name=null, $email=null,$password_hash=null) {
            parent::__construct($full_name, $email, $password_hash);
            $this->conn = $conn; 
        }

        public function save()
        {
            $query = "INSERT INTO users (full_name, email, password_hash) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($query);
    
            $stmt->bind_param('sss', $this->getName(), $this->getEmail(), $this->getPassword());
            return $stmt->execute();
        }
    
        public static function findByEmail($conn, $email)
        {
            $query = "SELECT * FROM users WHERE email = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('s',  getEmail());
            $stmt->execute();
    
            $userData = $stmt->get_result()->fetch_assoc();
    
            if ($userData) {
                return new self($conn, $userData['full_name'], $userData['email'], $userData['password_hash']);
            }
    
            return null; 
        }
    
        public function update()
        {
            $query = "UPDATE users SET full_name = ?, password_hash = ? WHERE email = ?";
            $stmt = $this->conn->prepare($query);
    
            $stmt->bind_param('sss', $this->getName(),$this->getPassword(), $this->getEmail());
    
            return $stmt->execute();
        }
    
        public function delete()
        {
            $query = "DELETE FROM users WHERE email = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('s', $this->getEmail());
    
            return $stmt->execute();
        }



    }



?>