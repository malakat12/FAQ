<?php

include ("/../connection/connect.php");
 
$sql ="CREATE TABLE IF NOT EXISTS questions(
    id INT AUTO_INCREMENT PRMARY KEY,
    question Text NOT NULL,	
    answer Text NOT NULL
)";

if ($mysqli->query($sql)==TRUE){
    echo"Table 'Questions' successfully created";
} else{
    echo"error creating 'Questions' Table". $mysqli->error;
}



?>