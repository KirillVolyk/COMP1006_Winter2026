<?php
// Have format set
require "includes/header.php";
//connect to db
require "includes/connect.php";
// make sure we received an ID
if (!isset($_GET['id'])) {
  die("No order ID provided.");
}

$taskId = $_GET['id'];

// create the query 
$sql = "DELETE FROM tasks WHERE id = :task_id";

//prepare 
$stmt = $pdo->prepare($sql);

//bind 
$stmt->bindParam(':task_id', $taskId, PDO::PARAM_INT);

//execute
$stmt->execute();

// Redirect back to admin list
header("Location: tasks.php");
exit;
?>

<?php require "includes/footer.php"; ?>

