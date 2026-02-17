<?php

require "includes/connect.php";

$sql = "SELECT * FROM tasks ORDER BY tasked_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$subscribers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="container mt-4">
  <h1>Subscribers</h1>

  <?php if (count($subscribers) === 0): ?>
    <p>No subscribers yet.</p>
  <?php else: ?>
    <table class="table table-bordered mt-3">
      <thead>
        <tr>
          <th>ID</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Tasked</th>
        </tr>
      </thead>
      <tbody>
        
        <?php foreach ($tasks as $task): ?>
          <tr>
            <td><?= htmlspecialchars($task['id']) ?></td>
            <td><?= htmlspecialchars($task['first_name']) ?></td>
            <td><?= htmlspecialchars($task['last_name']) ?></td>
            <td><?= htmlspecialchars($task['email']) ?></td>
            <td><?= htmlspecialchars($task['tasked_at']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

  <p class="mt-3">
    <a href="index.php">Back to Task Tracker</a>
  </p>
</main>

<?php require "includes/footer.php"; ?>
