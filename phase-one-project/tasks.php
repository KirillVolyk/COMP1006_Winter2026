<?php
require_once("includes/header.php");
require "includes/connect.php";

$sql = "SELECT * FROM tasks ORDER BY tasked_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="container mt-4">
  <h1>Tasks</h1>

  <?php if (count($tasks) === 0): ?>
    <p>No tasks yet.</p>
  <?php else: ?>
    <table class="table table-bordered mt-3">
      <thead>
        <tr>
          <th>ID</th>
          <th>Task Name</th>
          <th>Priority</th>
          <th>Time Estimate</th>
          <th>Deadline</th>
          <th>Status</th>
          <th>Tasked At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        
        <?php foreach ($tasks as $task): ?>
          <tr>
            <td><?= htmlspecialchars($task['task_id']) ?></td>
            <td><?= htmlspecialchars($task['task_name']) ?></td>
            <td><?= htmlspecialchars($task['task_priority']) ?></td>
            <td><?= htmlspecialchars($task['task_time_estimate']) ?></td>
            <td><?= htmlspecialchars($task['task_deadline']) ?></td>
            <td><?= htmlspecialchars($task['task_status']) ?></td>
            <td><?= htmlspecialchars($task['tasked_at']) ?></td>
            <td>
                <!-- Sends the ID to update.php -->
                <a
                  class="btn btn-sm btn-warning"
                  href="update.php?task_id=<?= urlencode($task['task_id']); ?>">
                  Update
                </a>
                <a
                  class="btn btn-sm btn-danger mt-2"
                  href="delete.php?task_id=<?= urlencode($task['task_id']); ?>"
                  onclick="return confirm('Are you sure you want to delete this task?');">
                  Delete
                </a>
              </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

  <p class="mt-3">
    <a href="index.php">Back to Task Manager</a>
  </p>
</main>

<?php require_once "includes/footer.php"; ?>
