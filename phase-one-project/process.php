<?php
// Have format set
require "includes/header.php";
// Connect to the database
require "includes/connect.php";
//   TODO: Grab form data with validation and sanitization



$sql = "INSERT INTO tasks (task_name, task_priority, task_time_estimate, task_deadline, task_status) VALUES (:task_name, :task_priority, :task_time_estimate, :task_deadline, :task_status)";

// Prepare the statement
$stmt = $pdo->prepare($sql);

// Bind
$stmt->bindParam(':task_name', $_POST['task_name']);
$stmt->bindParam(':task_priority', $_POST['task_priority']);
$stmt->bindParam(':task_time_estimate', $_POST['task_time_estimate']);
$stmt->bindParam(':task_deadline', $_POST['task_deadline']);
$stmt->bindParam(':task_status', $_POST['task_status']);

// Execute with form data
$stmt->execute();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Created</title>
</head>

<body>
    <main class="container mt-4">
        <h2>Task Made!</h2>

        <!-- TODO: Display a confirmation message -->
        <p>Great, <?= htmlspecialchars($_POST['task_name']) ?> has been added to the Task List.</p>
        <p class="mt-3">
            <a href="tasks.php">View Tasks</a>
        </p>
    </main>
</body>

</html>
<?php require_once("includes/footer.php"); ?>