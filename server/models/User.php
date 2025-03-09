<?php
    require_once __DIR__ . '/../connection/connect.php';
    require_once __DIR__ . '/UserSkeleton.php';

    class User extends UserSkeleton{

        private $conn;

        public function __construct($conn, $full_name, $email,$pass_hash) {
            parent::__construct($full_name, $email, $pass_hash);
            $this->conn = $conn; 
        }

        public function save()
        {
            $query = "INSERT INTO users (full_name, email, pass_hash) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($query);
    
            if (!$stmt) {
                error_log("Prepare failed: " . $this->conn->error);
                return false;
            }

            $full_name = $this->getName();
            $email = $this->getEmail();
            $pass_hash = $this->getPassword();
            $stmt->bind_param('sss', $full_name, $email, $pass_hash);

            if (!$stmt->execute()) {
                error_log("Execute failed: " . $stmt->error);
                return false;
            }
        
            return true;
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
                return new self($conn, $userData['full_name'], $userData['email'], $userData['pass_hash']);
            }

            return null;
        }

    
        public function update($id)
        {
            $query = "UPDATE users SET full_name = ?, email = ?, pass_hash = ? WHERE id = ?";
            $stmt = $this->conn->prepare($query);
    
            $full_name = $this->getName();
            $email = $this->getEmail();
            $pass_hash = $this->getPassword();
            $stmt->bind_param('sss', $full_name, $email, $pass_hash, $id);    
            return $stmt->execute();
        }
    
        public function delete($id)
        {
            $query = "DELETE FROM users WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $id=getid();
            $stmt->bind_param('i', $id);
    
            return $stmt->execute();
        }



    }



?>