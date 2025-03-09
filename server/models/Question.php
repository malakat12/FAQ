<?php
    require_once __DIR__ . '/../connection/connect.php';
    require_once __DIR__ . '/QuestionSkeleton.php';

    class Question extends QuestionSkeleton{

        private $conn;

        public function __construct($conn, $id = null, $question=null, $answer=null) {
            parent::__construct($id, $question, $answer);
            $this->conn = $conn; 
        }

        
        public function save()
        {
            $query = "INSERT INTO questions (question, answer) VALUES (?, ?)";
            $stmt = $this->conn->prepare($query);
    
            $stmt->bind_param('ss', $this->getQuestion(), $this->getAnswer());
            return $stmt->execute();
        }
    
        public static function findId($conn, $id)
        {
            $query = "SELECT * FROM questions WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('i',  $id);
            $stmt->execute();
    
            $questionData = $stmt->get_result()->fetch_assoc();
    
            if ($questionData) {
                return new self($conn, $questionData['id'], $questionData['question'], $questionData['answer']);
            }
    
            return null; 
        }
    
        public function update()
        {
            $query = "UPDATE questions SET question = ?  , answer = ? WHERE id = ?";
            $stmt = $this->conn->prepare($query);
    
            $stmt->bind_param('ssi', $this->getQuestion(),$this->getAnswer(),$this->id);
    
            return $stmt->execute();
        }
    
        public function delete()
        {
            $query = "DELETE FROM questions WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('i', $this->getid());
    
            return $stmt->execute();
        }

        public static function searchByKeyword($conn, $keyword)
        {
            $keyword = "%$keyword%";
            $query = "SELECT * FROM questions WHERE question LIKE ? OR answer LIKE ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('ss', $keyword, $keyword);
            $stmt->execute();
    
            $result = $stmt->get_result();
            $questions = [];
    
            while ($row = $result->fetch_assoc()) {
                $questions[] = new self($conn, $row['id'], $row['question'], $row['answer']);
            }
    
            return $questions;
        }

    }
?>