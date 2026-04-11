<?php
// this file handles proper pathing
require_once dirname(__DIR__) . '/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <link href="<?= URL_ROOT ?>/styles/style.css" rel="stylesheet">
</head>
<body>

<header class="bg-dark text-white py-3 mb-3">
    <div class="container d-flex align-items-center justify-content-between">

        <!-- logo -->
        <a href="<?= URL_ROOT ?>/index.php" class="text-white text-decoration-none d-flex align-items-center gap-2">
            <img src="<?= URL_ROOT ?>/assets/tmlogo.png" alt="Task Manager Logo" class="logo" style="height:40px;">
            <span class="fw-bold fs-5">Task Manager</span>
        </a>

        <!-- navigation(if loggrd in) -->
        <nav class="d-flex gap-3 align-items-center">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="<?= URL_ROOT ?>/crud/tasks.php" class="text-white text-decoration-none">Tasks</a>
                <a href="<?= URL_ROOT ?>/index.php" class="text-white text-decoration-none">New Task</a>

                <span class="text-white">
                    👤 <?= htmlspecialchars($_SESSION['username']) ?>
                </span>

                <a href="<?= URL_ROOT ?>/security/logout.php" class="btn btn-outline-light btn-sm">Logout</a>
            <?php else: ?>
                <a href="<?= URL_ROOT ?>/security/login.php" class="text-white text-decoration-none">Login</a>
                <a href="<?= URL_ROOT ?>/security/register.php" class="btn btn-outline-light btn-sm">Sign Up</a>
            <?php endif; ?>
        </nav>

    </div>
</header>
