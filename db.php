<?php

$host = 'localhost';
$dbname = 'storage_sys';
$username = 'root';
$password = 'root'; //this username and password are only for the projects i use more secure info in a real life scenario


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    die("Connection failed: " . $e->getMessage());
}
?>