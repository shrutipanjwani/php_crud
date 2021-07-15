<?php 
    $host='localhost';
    $db = 'crud_operations';
    $username = 'root';
    $password = '';
    $dsn= "mysql:host=$host;dbname=$db";
    $ConnectingDB = new PDO($dsn, $username, $password);
    $ConnectingDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>