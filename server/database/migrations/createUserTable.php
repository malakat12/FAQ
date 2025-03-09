<?php
include ("/../connection/connect.php");
 
$sql ="CREATE TABLE IF NOT EXISTS users(
    id INT AUTO_INCREMENT PRMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    pass_hash VARCHAR(255) NOT NULL
)
";

if ($mysqli->query($sql)==TRUE){
    echo"Table 'users' successfully created";
} else{
    echo"error creating 'users' Table". $mysqli->error;
}

?>