<?php
$servername = "localhost";
$username = "root";
$password= "";
$dbname = "Read&Relax";

$connection = new mysqli($servername, $username, $password, $dbname);

if($connection->connect_error){
    die("Connection Failed: ". $connection->connect_error);
}

?>