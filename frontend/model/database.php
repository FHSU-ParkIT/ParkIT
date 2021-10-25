<?php
    $dsn = 'mysql:host=localhost;dbname=';
    $username = 'root';
    //$password = '';

    try{
        $db = new PDO ($dsn, $username)
    }catch(PDOException $e){
        $err = "Database Error: ";
        $err .= $e->getMessage();
        include('view/error.php');
        exit();
    }