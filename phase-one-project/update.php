<?php
// Have format set
require "includes/header.php";
// Connect to the database
require "includes/connect.php";
// Make sure to get the id
if (!isset($_GET['task_id'])) {
  die("No Task ID provided.");
}

$taskId = $_GET['task_id'];
// Handle form submission if its POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Basic sanitization (trim removes extra spaces
  $taskName = trim($_POST['task_name'] ?? '');
  $taskPriority = trim($_POST['task_priority'] ?? '');
  $taskTimeEstimate = trim($_POST['task_time_estimate'] ?? '');
  $taskDeadline = trim($_POST['task_deadline'] ?? '');
  $taskStatus = trim($_POST['task_status'] ?? '');


  // Input Fields (force to their own types, prevent blanks)
  $taskTimeEstimate = (int)($taskTimeEstimate ?? 0);

  // Validation
  if (!preg_match('/^[a-zA-Z0-9\s]+$/', $taskName)) {
    $error = "Task name is required and must only contain letters, numbers, and spaces.";
  } else {
  // Update query with named placeholders
    $sql = "UPDATE tasks
            SET task_name = :task_name,
                task_priority = :task_priority,
                task_time_estimate = :task_time_estimate,
                task_deadline = :task_deadline,
                task_status = :task_status
            WHERE task_id = :task_id";

    $stmt = $pdo->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':task_name', $taskName);
    $stmt->bindParam(':task_priority', $taskPriority);
    $stmt->bindParam(':task_time_estimate', $taskTimeEstimate);
    $stmt->bindParam(':task_deadline', $taskDeadline);
    $stmt->bindParam(':task_status', $taskStatus);
    $stmt->bindParam(':task_id', $taskId);

    $stmt->execute();

    // Redirect back to the tasks list 
    header("Location: tasks.php");
    exit;
  }
}


// Fetch the existing task data
$sql = "SELECT * FROM tasks WHERE task_id = :task_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':task_id', $taskId);
$stmt->execute();

$task = $stmt->fetch();

// If no task found
if (!$task) {
  die("Task not found.");
}
?>

<!-- Show task id -->
<main class="container mt-4">
  <h2>Update Task #<?= htmlspecialchars($task['task_id']); ?></h2>

  <?php if (!empty($error)): ?>
    <p class="text-danger"><?= htmlspecialchars($error); ?></p>
  <?php endif; ?>

  <!--
    This form is pre-filled using the task data pulled from the database.
    The admin(in the) can edit the values and submit to update the row.
  -->
  <form method="post">

    <h4 class="mt-3">Task Info</h4>

    <!-- Task Name no Special characters -->
    <label class="form-label">Task Name</label>
    <input
      type="text"
      name="task_name"
      class="form-control mb-3"
      value="<?= htmlspecialchars($task['task_name']); ?>"
      required
    >

    <!-- Task Priority 3 Options-->
    <label class="form-label">Task Priority</label>
    <select name="task_priority" class="form-select mb-3">
        <option value="Low" <?= $task['task_priority'] === 'Low' ? 'selected' : '' ?>>Low</option>
        <option value="Medium" <?= $task['task_priority'] === 'Medium' ? 'selected' : '' ?>>Medium</option>
        <option value="High" <?= $task['task_priority'] === 'High' ? 'selected' : '' ?>>High</option>
    </select>

    <!-- Time Estimate (minutes) positive -->
    <label class="form-label">Task Time Estimate (Minutes)</label>
    <input
      type="number"
      name="task_time_estimate"
      class="form-control mb-3"
      value="<?= htmlspecialchars($task['task_time_estimate']); ?>"
    >

    <!-- Deadline YYYY(YY)-MM--DD :::: Fix the extra 2 digits for the year, somehow... -->
    <label class="form-label">Task Deadline</label>
    <input
      type="datetime-local"
      name="task_deadline"
      class="form-control mb-3"
      value="<?= htmlspecialchars(str_replace(' ', 'T', $task['task_deadline'])); ?>"
    >

    <!-- Task Status 3 Options -->
    <label class="form-label">Task Status</label>
    <select name="task_status" class="form-select mb-3">
        <option value="Not Started" <?= $task['task_status'] === 'Not Started' ? 'selected' : '' ?>>Not Started</option>
        <option value="In Progress" <?= $task['task_status'] === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
        <option value="Completed" <?= $task['task_status'] === 'Completed' ? 'selected' : '' ?>>Completed</option>
    </select>

    <button class="btn btn-primary">Save Changes</button>
    <a href="tasks.php" class="btn btn-secondary">Cancel</a>

</form>


  </form>
</main>

<?php require "includes/footer.php"; ?>
