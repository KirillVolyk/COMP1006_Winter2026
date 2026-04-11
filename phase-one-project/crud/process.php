<?php
// this file handles proper pathing
require_once dirname(__DIR__) . '/config.php';

// DB connection
require_once INCLUDES . 'connect.php';

// 1. Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request");
}

// 2. Sanitize input
$taskName         = trim(filter_input(INPUT_POST, 'task_name', FILTER_SANITIZE_SPECIAL_CHARS));
$taskPriority     = trim(filter_input(INPUT_POST, 'task_priority', FILTER_SANITIZE_SPECIAL_CHARS));
$taskTimeEstimate = filter_input(INPUT_POST, 'task_time_estimate', FILTER_VALIDATE_INT);
$taskDeadline     = trim(filter_input(INPUT_POST, 'task_deadline', FILTER_SANITIZE_SPECIAL_CHARS));
$taskStatus       = trim(filter_input(INPUT_POST, 'task_status', FILTER_SANITIZE_SPECIAL_CHARS));

$errors = [];

// 3. Server Side Validation
if (!preg_match('/^[a-zA-Z0-9\s]+$/', $taskName)) {
    $errors[] = "Task name is required and must only contain letters, numbers, and spaces.";
}

if (!in_array($taskPriority, ['Low', 'Medium', 'High'])) {
    $errors[] = "Invalid priority selected.";
}

if ($taskTimeEstimate === false || $taskTimeEstimate < 0) {
    $errors[] = "Time estimate must be a positive number of minutes.";
}

if ($taskDeadline === '' || $taskDeadline === null) {
    $errors[] = "Deadline is required.";
}

if (!in_array($taskStatus, ['Not Started', 'In Progress', 'Completed'])) {
    $errors[] = "Invalid task status.";
}

// If errors, show them
if (!empty($errors)) {
    require_once INCLUDES . 'header.php';

    echo "<div class='alert alert-danger'>";
    echo "<h2>Please fix the following:</h2><ul>";
    foreach ($errors as $e) {
        echo "<li>" . htmlspecialchars($e) . "</li>";
    }
    echo "</ul></div>";

    require_once INCLUDES . 'footer.php';
    exit;
}

// 4. Insert into DB
$sql = "INSERT INTO tasks 
        (task_name, task_priority, task_time_estimate, task_deadline, task_status)
        VALUES 
        (:task_name, :task_priority, :task_time_estimate, :task_deadline, :task_status)";

$stmt = $pdo->prepare($sql);

$stmt->bindParam(':task_name', $taskName);
$stmt->bindParam(':task_priority', $taskPriority);
$stmt->bindParam(':task_time_estimate', $taskTimeEstimate, PDO::PARAM_INT);
$stmt->bindParam(':task_deadline', $taskDeadline);
$stmt->bindParam(':task_status', $taskStatus);

$stmt->execute();

// 5. Confirmation
require_once INCLUDES . 'header.php';
?>

<div class="alert alert-success">
    <h2>Task Created!</h2>
    <p>Your task <strong><?= htmlspecialchars($taskName) ?></strong> has been added.</p>
</div>

<p><a href="<?= URL_ROOT ?>/crud/tasks.php">View Tasks</a></p>

<?php require_once INCLUDES . 'footer.php'; ?>
