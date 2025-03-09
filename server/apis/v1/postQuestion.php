<?php
    require_once __DIR__ . '/../../connection/connect.php';
    require_once __DIR__ . '/../../models/Question.php';

    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *"); 
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); 
    header("Access-Control-Allow-Headers: Content-Type"); 
    
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        exit(0); 
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['question'], $data['answer'])) {
            echo json_encode(['error' => 'Missing required fields']);
            exit;
        }

        $question = trim($data['question']);
        $answer = trim($data['answer']);

        try {
            $question = new Question($conn, $question, $answer);

            if ($question->save()) {
                echo json_encode(['success' => 'Question posted successfully']);
            } else {
                echo json_encode(['error' => 'Failed to post question']);
            }
        } catch (Exception $e) {
            echo json_encode(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }
?>
