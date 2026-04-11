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
$taskName         = trim(filter_input(INPUT_POST, 'task_name',          FILTER_SANITIZE_SPECIAL_CHARS));
$taskPriority     = trim(filter_input(INPUT_POST, 'task_priority',      FILTER_SANITIZE_SPECIAL_CHARS));
$taskTimeEstimate = filter_input(INPUT_POST, 'task_time_estimate',      FILTER_VALIDATE_INT);
$taskDeadline     = trim(filter_input(INPUT_POST, 'task_deadline',      FILTER_SANITIZE_SPECIAL_CHARS));
$taskStatus       = trim(filter_input(INPUT_POST, 'task_status',        FILTER_SANITIZE_SPECIAL_CHARS));

// This will store the image path for the database
$imagePath = null;

// Array for validation errors
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

// Validate and handle image upload (only if a file was chosen)
if (isset($_FILES['task_image']) && $_FILES['task_image']['error'] !== UPLOAD_ERR_NO_FILE) {

    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    $maxSize      = 5 * 1024 * 1024; // 5 MB

    if ($_FILES['task_image']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "Image upload failed.";

    } elseif ($_FILES['task_image']['size'] > $maxSize) {
        $errors[] = "Image must be under 5 MB.";

    } else {
        // Check real MIME type using finfo (not just browser-reported type)
        $finfo    = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($_FILES['task_image']['tmp_name']);

        if (!in_array($mimeType, $allowedTypes)) {
            $errors[] = "Only JPG, PNG, and WEBP images are allowed.";

        } else {
            // Build upload folder path
            $uploadDir = BASE_PATH . '/uploads/';

            // Generate a unique filename to avoid conflicts
            $ext      = pathinfo($_FILES['task_image']['name'], PATHINFO_EXTENSION);
            $filename = bin2hex(random_bytes(12)) . '.' . strtolower($ext);

            if (!move_uploaded_file($_FILES['task_image']['tmp_name'], $uploadDir . $filename)) {
                $errors[] = "Could not save the image. Check folder permissions.";
            } else {
                $imagePath = URL_ROOT . '/uploads/' . $filename;
            }
        }
    }
}

// If there are no errors, insert into DB
if (empty($errors)) {
    $sql = "INSERT INTO tasks 
            (task_name, task_priority, task_time_estimate, task_deadline, task_status, image_path)
            VALUES 
            (:task_name, :task_priority, :task_time_estimate, :task_deadline, :task_status, :image_path)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':task_name',          $taskName);
    $stmt->bindParam(':task_priority',      $taskPriority);
    $stmt->bindParam(':task_time_estimate', $taskTimeEstimate, PDO::PARAM_INT);
    $stmt->bindParam(':task_deadline',      $taskDeadline);
    $stmt->bindParam(':task_status',        $taskStatus);
    $stmt->bindParam(':image_path',         $imagePath);
    $stmt->execute();

    $success = "Task created successfully!";
}

// Show header after processing
require_once INCLUDES . 'header.php';
?>

<?php if (!empty($errors)): ?>
    <div class="container mt-4">
        <div class="alert alert-danger">
            <h3>Please fix the following:</h3>
            <ul class="mb-0">
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <a href="<?= URL_ROOT ?>/index.php" class="btn btn-secondary">Go Back</a>
    </div>
<?php endif; ?>

<?php if (isset($success)): ?>
    <div class="container mt-4">
        <div class="alert alert-success">
            <h2>Task Created!</h2>
            <p>Your task <strong><?= htmlspecialchars($taskName) ?></strong> has been added.</p>
        </div>
        <a href="<?= URL_ROOT ?>/crud/tasks.php" class="btn btn-primary">View Tasks</a>
        <a href="<?= URL_ROOT ?>/index.php"       class="btn btn-secondary ms-2">Add Another</a>
    </div>
<?php endif; ?>

<?php require_once INCLUDES . 'footer.php'; ?>