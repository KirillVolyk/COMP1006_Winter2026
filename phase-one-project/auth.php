<?php
// includes/auth.php
// -------------------------------------------------------
// Include this file at the top of any page that requires
// the user to be logged in. It starts the session and
// redirects to login.php if no valid session exists.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}