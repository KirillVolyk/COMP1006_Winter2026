<?php 
// $host     = "172.31.22.43";
// $db       = "Kirill200638948";
// $user     = "Kirill200638948";
// $password = "gla4Z4boty";
$host     = "localhost";
$db       = "tasksdb";
$user     = "root";
$password = "";

//points to the database
$dsn = "mysql:host=$host;dbname=$db";

//try to connect, if connected echo a yay!
try {
   $pdo = new PDO ($dsn, $user, $password); 
   $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
//what happens if there is an error connecting 
catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage()); 
}
