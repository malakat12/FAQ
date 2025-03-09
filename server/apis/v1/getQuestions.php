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

    $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

    Question::getQuestions($conn, $keyword);

?>
