<?php

//store db connection info in a variaable
$host = "localhost";  //hostname  
$db = "lab_one";
$user = "root";
$pword = "";

//data source name - type of db, location and db name
$dsn = "mysql:host=$host;dbname=$db";

//create a PDO instance
//what we want to happen
try {
    $pdo = new PDO($dsn, $user, $pword);
    //set error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p> Connected successfully </p>";
} 
catch (PDOException $e) { // what happenes when thigs go wrong
    die ("Database connection failed: " . $e->getMessage());
}