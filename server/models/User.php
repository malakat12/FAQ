<?php
    require_once __DIR__ . '/../connection/connect.php';
    require_once __DIR__ . '/UserSkeleton.php';

    class User extends UserSkeleton{

        private $conn;

        public function __construct($conn,$id=null, $full_name=null, $email=null,$password_hash=null) {
            parent::__construct($id, $full_name, $email, $password_hash);
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
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $userData = $result->fetch_assoc();

            if ($userData) {
                return new self($conn, $userData['id'], $userData['full_name'], $userData['email'], $userData['password_hash']);
            }

            return null;
        }

    
        public function update()
        {
            $query = "UPDATE users SET full_name = ?, email = ?, password_hash = ? WHERE id = ?";
            $stmt = $this->conn->prepare($query);
    
            $stmt->bind_param('ssi', $this->getName(),$this->getEmail(),$this->getPassword(), $this->id);
    
            return $stmt->execute();
        }
    
        public function delete()
        {
            $query = "DELETE FROM users WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('i', $this->getid());
    
            return $stmt->execute();
        }



    }



?>