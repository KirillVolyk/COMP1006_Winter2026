<?php
// includes/header.php
// -------------------------------------------------------
// Outputs the page <head>, Bootstrap links, and a nav bar
// that shows different links depending on login state.

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
          rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
          crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
            crossorigin="anonymous"></script>
    <link href="styles/style.css" rel="stylesheet">
</head>
<body>

<header class="bg-dark text-white py-3 mb-3">
    <div class="container d-flex align-items-center justify-content-between">

        <!-- logo -->
        <a href="index.php" class="text-white text-decoration-none d-flex align-items-center gap-2">
            <img src="assets/tmlogo.png" alt="Task Manager Logo" class="logo" style="height:40px;">
            <span class="fw-bold fs-5">Task Manager</span>
        </a>

        <!--navigation -->
        <nav class="d-flex gap-3 align-items-center">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="tasks.php"   class="text-white text-decoration-none">Tasks</a>
                <a href="index.php"   class="text-white text-decoration-none">New Task</a>
                <a href="profile.php" class="text-white text-decoration-none">
                    👤 <?= htmlspecialchars($_SESSION['username']) ?>
                </a>
                <a href="logout.php"  class="btn btn-outline-light btn-sm">Logout</a>
            <?php else: ?>
                <a href="login.php"    class="text-white text-decoration-none">Login</a>
                <a href="register.php" class="btn btn-outline-light btn-sm">Sign Up</a>
            <?php endif; ?>
        </nav>

    </div>
</header>