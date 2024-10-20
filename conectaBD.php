<?php
$servername = "localhost";
$username = "root";        
$password = "";           
$dbname = "imobiliaria";    
   
$mysqli = new mysqli($servername, $username, $password, $dbname);

if (!$mysqli) {  
  die("Falha de conexão: " . mysqli_connect_error());
}
?>