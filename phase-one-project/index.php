<?php
require_once "includes/auth.php";
require_once "includes/header.php";
?>

<main class="container mt-4">
    <h1>Make A Task!</h1>

    <!-- enctype="multipart/form-data" is required for file uploads -->
    <form action="<?= URL_ROOT ?>/crud/process.php" method="post" enctype="multipart/form-data" class="mt-3">

        <label class="form-label" for="task_name">Task Name</label>
        <input class="form-control" type="text" id="task_name" name="task_name"
               pattern="[a-zA-Z0-9 ]+" title="Letters, numbers, and spaces only." required>

        <label class="form-label mt-3" for="task_priority">Task Priority</label>
        <select class="form-select" id="task_priority" name="task_priority" required>
            <option value="Low">Low</option>
            <option value="Medium">Medium</option>
            <option value="High">High</option>
        </select>

        <label class="form-label mt-3" for="task_time_estimate">Time Estimate (Minutes)</label>
        <input class="form-control" type="number" id="task_time_estimate"
               name="task_time_estimate" min="1" required>

        <label class="form-label mt-3" for="task_deadline">Task Deadline</label>
        <input class="form-control" type="datetime-local" id="task_deadline"
               name="task_deadline" required>

        <label class="form-label mt-3" for="task_status">Task Status</label>
        <select class="form-select" id="task_status" name="task_status" required>
            <option value="Not Started">Not Started</option>
            <option value="In Progress">In Progress</option>
            <option value="Completed">Completed</option>
        </select>

        <!-- Image upload (optional) -->
        <label class="form-label mt-3" for="task_image">Task Image (JPG, PNG, WEBP, <5MB)</label>
        <input class="form-control" type="file" id="task_image" name="task_image"
               accept=".jpg,.jpeg,.png,.webp">

        <button class="btn btn-primary mt-4" type="submit">Create Task</button>
    </form>

    <p class="mt-4">
        <a href="<?= URL_ROOT ?>/crud/tasks.php">View Tasks</a>
    </p>
</main>

<?php require_once "includes/footer.php"; ?>