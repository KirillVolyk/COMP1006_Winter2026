<?php require_once("includes/header.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager - Create New Task</title>
</head>

<body>

    <main class="container mt-4">
        <h1>Make A Task!</h1>

        <!-- Set actions per field -->
        <form action="process.php" method="post" class="mt-3">
            <!-- Task Name -->
            <label class="form-label" for="task_name">Task Name</label>
            <input class="form-control" type="text" id="task_name" name="task_name">
            <!-- Task Priority -->
            <label class="form-label mt-3" for="task_priority">Task Priority</label>
            <select class="form-select" id="task_priority" name="task_priority">
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
            </select>
            <!-- Time Estimate -->
             <!-- Note: Time format is weird, in HH:MM:AM/PM -->
            <label class="form-label mt-3" for="task_time_estimate">Time Estimate (Minutes)</label>
            <input class="form-control" type="number" id="task_time_estimate" name="task_time_estimate">
            <!-- Task Deadline -->
            <label class="form-label mt-3" for="task_deadline">Task Deadline</label>
            <input class="form-control" type="datetime-local" id="task_deadline" name="task_deadline">
            <!-- Task Status -->
            <label class="form-label mt-3" for="task_status">Task Status</label>
            <select class="form-select" id="task_status" name="task_status">
                <option value="Not Started">Not Started</option>
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
            </select>
            <!-- Button -->
            <button class="btn btn-primary mt-4" type="submit">Create Task</button>
        </form>
        <!-- View Form -->
        <p class="mt-4">
            <a href="tasks.php">View Tasks</a>
        </p>
    </main>
</body>

</html>

<?php require_once("includes/footer.php"); ?>