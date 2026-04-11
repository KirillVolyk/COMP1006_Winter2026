<?php
// this file handles proper pathing
require_once dirname(__DIR__) . '/config.php';

// Auth + header + db
require_once INCLUDES . 'auth.php';
require_once INCLUDES . 'header.php';
require_once INCLUDES . 'connect.php';

$sql  = "SELECT * FROM tasks ORDER BY tasked_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="container mt-4">
    <h1>Tasks</h1>

    <?php if (count($tasks) === 0): ?>
        <p>No tasks yet. <a href="<?= URL_ROOT ?>/index.php">Create one!</a></p>
    <?php else: ?>
        <table class="table table-bordered mt-3 align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Task Name</th>
                    <th>Priority</th>
                    <th>Time Estimate</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?= htmlspecialchars($task['task_id']) ?></td>

                        <!-- Image thumbnail -->
                        <td>
                            <?php if (!empty($task['image_path'])): ?>
                                <img
                                    src="<?= htmlspecialchars($task['image_path']) ?>"
                                    alt="Task Image"
                                    style="width:60px; height:60px; object-fit:cover; border-radius:4px;">
                            <?php else: ?>
                                <span class="text-muted small">No image</span>
                            <?php endif; ?>
                        </td>

                        <td><?= htmlspecialchars($task['task_name']) ?></td>
                        <td><?= htmlspecialchars($task['task_priority']) ?></td>
                        <td><?= htmlspecialchars($task['task_time_estimate']) ?> min</td>
                        <td><?= htmlspecialchars($task['task_deadline']) ?></td>
                        <td><?= htmlspecialchars($task['task_status']) ?></td>
                        <td><?= htmlspecialchars($task['tasked_at']) ?></td>
                        <td>
                            <a class="btn btn-sm btn-warning"
                               href="<?= URL_ROOT ?>/crud/update.php?task_id=<?= urlencode($task['task_id']) ?>">
                                Update
                            </a>
                            <a class="btn btn-sm btn-danger mt-1"
                               href="<?= URL_ROOT ?>/crud/delete.php?task_id=<?= urlencode($task['task_id']) ?>"
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
        <a href="<?= URL_ROOT ?>/index.php" class="btn btn-primary">+ New Task</a>
    </p>
</main>

<?php require_once INCLUDES . 'footer.php'; ?>