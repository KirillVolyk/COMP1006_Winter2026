<?php
//connect to db
require "connect.php";
// make sure we exit if there is not an ID given
if (!isset($_GET['id'])) {
  die("No book ID provided.");
}
// get the ID from the URL
$id = $_GET['id'];

// create the query 
$sql = "DELETE FROM reviews WHERE id = :id";

//prepare 
$stmt = $pdo->prepare($sql);

//bind 
$stmt->bindParam(':id', $id, PDO::PARAM_INT);

//execute
$stmt->execute();

// Redirect back to admin list
header("Location: admin.php");
exit;
?>

