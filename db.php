<?php
try{
    $pdo = new PDO("mysql:host=localhost;dbname=rendez_vous;", "root", "root");
    $pdo->setAttribute(PDO::ERRMODE_EXCEPTION, PDO::ATTR_ERRMODE);
}catch(PDOException $e){
    die("ERROR IN DATABASE". $e->getMessage());
}
?>