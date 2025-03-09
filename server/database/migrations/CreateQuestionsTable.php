<?php

include ("../../connection/connect.php");
 
$sql ="CREATE TABLE IF NOT EXISTS questions(
    id INT AUTO_INCREMENT PRIMARY KEY,
    question Text NOT NULL,	
    answer Text NOT NULL
)";

if ($conn->query($sql)==TRUE){
    echo "Table 'Questions' successfully created";
} else{
    echo "error creating 'Questions' Table". $conn->error;
}



?>