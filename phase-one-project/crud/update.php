<?php
// this file handles proper pathing
require_once dirname(__DIR__) . '/config.php';

// header + db
require_once INCLUDES . 'header.php';
require_once INCLUDES . 'connect.php';

if (!isset($_GET['task_id'])) {
    die("No Task ID provided.");
}

$taskId = $_GET['task_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Basic sanitization
    $taskName         = trim($_POST['task_name']          ?? '');
    $taskPriority     = trim($_POST['task_priority']       ?? '');
    $taskTimeEstimate = (int)($_POST['task_time_estimate'] ?? 0);
    $taskDeadline     = trim($_POST['task_deadline']       ?? '');
    $taskStatus       = trim($_POST['task_status']         ?? '');

    // Keep existing image unless a new one is uploaded
    $imagePath = $_POST['existing_image'] ?? null;

    $errors = [];

    if (!preg_match('/^[a-zA-Z0-9\s]+$/', $taskName)) {
        $errors[] = "Task name is required and must only contain letters, numbers, and spaces.";
    }

    // Handle image upload if a file was chosen
    if (isset($_FILES['task_image']) && $_FILES['task_image']['error'] !== UPLOAD_ERR_NO_FILE) {

        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        $maxSize      = 5 * 1024 * 1024; // 5 MB

        if ($_FILES['task_image']['error'] !== UPLOAD_ERR_OK) {
            $errors[] = "Image upload failed.";

        } elseif ($_FILES['task_image']['size'] > $maxSize) {
            $errors[] = "Image must be under 5 MB.";

        } elseif (!in_array($_FILES['task_image']['type'], $allowedTypes)) {
            $errors[] = "Only JPG, PNG, and WEBP images are allowed.";

        } else {
            $uploadDir = BASE_PATH . '/uploads/';
            $ext       = pathinfo($_FILES['task_image']['name'], PATHINFO_EXTENSION);
            $filename  = uniqid() . '.' . strtolower($ext);

            if (!move_uploaded_file($_FILES['task_image']['tmp_name'], $uploadDir . $filename)) {
                $errors[] = "Could not save the image.";
            } else {
                $imagePath = URL_ROOT . '/uploads/' . $filename;
            }
        }
    }

    if (empty($errors)) {
        $sql = "UPDATE tasks
                SET task_name = :task_name,
                    task_priority = :task_priority,
                    task_time_estimate = :task_time_estimate,
                    task_deadline = :task_deadline,
                    task_status = :task_status,
                    image_path = :image_path
                WHERE task_id = :task_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':task_name',          $taskName);
        $stmt->bindParam(':task_priority',      $taskPriority);
        $stmt->bindParam(':task_time_estimate', $taskTimeEstimate);
        $stmt->bindParam(':task_deadline',      $taskDeadline);
        $stmt->bindParam(':task_status',        $taskStatus);
        $stmt->bindParam(':image_path',         $imagePath);
        $stmt->bindParam(':task_id',            $taskId);
        $stmt->execute();

        header("Location: " . URL_ROOT . "/crud/tasks.php");
        exit;
    }
}

// Fetch the existing task data
$sql  = "SELECT * FROM tasks WHERE task_id = :task_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':task_id', $taskId);
$stmt->execute();
$task = $stmt->fetch();

if (!$task) {
    die("Task not found.");
}
?>

<main class="container mt-4">
    <h2>Update Task #<?= htmlspecialchars($task['task_id']); ?></h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <h3>Please fix the following:</h3>
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">

        <!-- keep track of existing image -->
        <input type="hidden" name="existing_image" value="<?= htmlspecialchars($task['image_path'] ?? '') ?>">

        <label class="form-label">Task Name</label>
        <input
            type="text"
            name="task_name"
            class="form-control mb-3"
            value="<?= htmlspecialchars($task['task_name']); ?>"
            required
        >

        <label class="form-label">Task Priority</label>
        <select name="task_priority" class="form-select mb-3">
            <option value="Low"    <?= $task['task_priority'] === 'Low'    ? 'selected' : '' ?>>Low</option>
            <option value="Medium" <?= $task['task_priority'] === 'Medium' ? 'selected' : '' ?>>Medium</option>
            <option value="High"   <?= $task['task_priority'] === 'High'   ? 'selected' : '' ?>>High</option>
        </select>

        <label class="form-label">Task Time Estimate (Minutes)</label>
        <input
            type="number"
            name="task_time_estimate"
            class="form-control mb-3"
            value="<?= htmlspecialchars($task['task_time_estimate']); ?>"
        >

        <label class="form-label">Task Deadline</label>
        <input
            type="datetime-local"
            name="task_deadline"
            class="form-control mb-3"
            value="<?= htmlspecialchars(str_replace(' ', 'T', $task['task_deadline'])); ?>"
        >

        <label class="form-label">Task Status</label>
        <select name="task_status" class="form-select mb-3">
            <option value="Not Started" <?= $task['task_status'] === 'Not Started' ? 'selected' : '' ?>>Not Started</option>
            <option value="In Progress" <?= $task['task_status'] === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
            <option value="Completed"   <?= $task['task_status'] === 'Completed'   ? 'selected' : '' ?>>Completed</option>
        </select>

        <!-- show current image if there is one -->
        <?php if (!empty($task['image_path'])): ?>
            <div class="mb-3">
                <label class="form-label">Current Image</label><br>
                <img
                    src="<?= htmlspecialchars($task['image_path']) ?>"
                    alt="Current task image"
                    style="width:120px; height:120px; object-fit:cover; border-radius:6px;"
                >
            </div>
        <?php endif; ?>

        <label for="task_image" class="form-label">Task Image (optional)</label>
        <input
            type="file"
            id="task_image"
            name="task_image"
            class="form-control mb-4"
            accept=".jpg,.jpeg,.png,.webp"
        >

        <button class="btn btn-primary">Save Changes</button>
        <a href="<?= URL_ROOT ?>/crud/tasks.php" class="btn btn-secondary">Cancel</a>
    </form>
</main>

<?php require_once INCLUDES . 'footer.php'; ?>