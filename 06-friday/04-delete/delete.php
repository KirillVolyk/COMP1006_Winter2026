<?php
/**
 * delete.php
 * ------------------------------------------------------------
 * Deletes one order from the orders1 table.
 * - Gets the customer_id from the URL (delete.php?id=5)
 * - Uses PDO + bindParam for safety
 * - Redirects back to orders.php
 */
require "includes/header.php";
//connect to db
require "includes/connect.php";
// make sure we received an ID
if (!isset($_GET['id'])) {
  die("No order ID provided.");
}

$customerId = $_GET['id'];

// create the query 
$sql = "DELETE FROM orders1 WHERE customer_id = :customer_id";

//prepare 
$stmt = $pdo->prepare($sql);

//bind 
$stmt->bindParam(':customer_id', $customerId, PDO::PARAM_INT);

//execute
$stmt->execute();

// Redirect back to admin list
header("Location: orders.php");
exit;
?>

<?php require "includes/footer.php"; ?>

