<?php
require "includes/header.php";
//  TODO: connect to the database 
require "includes/connect.php";
//   TODO: Grab form data (no validation or sanitization for this lab)

/*
  1. Write an INSERT statement with named placeholders
  2. Prepare the statement
  3. Execute the statement with an array of values


  4.

*/

$sql = "INSERT INTO subscribers (first_name, last_name, email) VALUES (:first_name, :last_name, :email)";

// Prepare the statement
$stmt = $pdo->prepare($sql);

//bind
$stmt->bindParam(':first_name', $_POST['first_name']);
$stmt->bindParam(':last_name', $_POST['last_name']);
$stmt->bindParam(':email', $_POST['email']);

// Execute with form data
$stmt->execute();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <main class="container mt-4">
        <h2>Thank You for Subscribing</h2>

        <!-- TODO: Display a confirmation message -->
        <p>Thanks, <?= htmlspecialchars($_POST['first_name']) ?>! You have been added to our mailing list.</p>
        <!-- Example: "Thanks, Name! You have been added to our mailing list." -->




        <p class="mt-3">
            <a href="subscribers.php">View Subscribers</a>
        </p>
    </main>
</body>

</html>