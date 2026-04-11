<?php
// this file handles proper pathing
require_once dirname(__DIR__) . '/config.php';

// header + db connection
require_once INCLUDES . 'header.php';
require_once INCLUDES . 'connect.php';

// make sure we received an ID
if (!isset($_GET['task_id'])) {
    die("No task ID provided.");
}

$taskId = $_GET['task_id'];

// create the query 
$sql = "DELETE FROM tasks WHERE task_id = :task_id";

// prepare 
$stmt = $pdo->prepare($sql);

// bind 
$stmt->bindParam(':task_id', $taskId, PDO::PARAM_INT);

// execute
$stmt->execute();

// Redirect back to admin list
header("Location: " . URL_ROOT . "/crud/tasks.php");
exit;
?>

<?php require_once INCLUDES . 'footer.php'; ?>
