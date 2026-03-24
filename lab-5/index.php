<?php
require "includes/header.php";
require "includes/connect.php";
session_start();

// note: I had to getg help from searching some of my issues online, this included video(s), search enginge, and error fixes from ai

// Check if user is logged in
$loggedIn = isset($_SESSION['user_id']);
$profileImage = null;

// If logged in, fetch their profile picture
if ($loggedIn) {
    $sql = "SELECT profile_image FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $_SESSION['user_id']);
    $stmt->execute();
    $profileImage = $stmt->fetchColumn();
}
?>

<main class="container mt-4">

    <h1 class="mb-4">Welcome to the Site</h1>

    <?php if ($loggedIn): ?>

        <h3 class="mb-3">Hello, <?= htmlspecialchars($_SESSION['username']); ?>!</h3>

        <p class="mb-4">Here is your profile picture:</p>

        <!-- Show profile picture if it exists -->
        <?php if ($profileImage): ?>
            <img src="<?= htmlspecialchars($profileImage); ?>" 
                 alt="Profile Picture" 
                 class="img-fluid rounded mb-4"
                 style="max-width: 300px;">
        <?php else: ?>
            <p>You have not uploaded a profile picture yet.</p>
            <a href="add-pfp.php" class="btn btn-primary">Upload Profile Picture</a>
        <?php endif; ?>

        <div class="mt-4">
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>

    <?php else: ?>

        <h3 class="mb-4">You are not logged in.</h3>

        <div class="text-center">
            <img src="images/default.png" 
                 alt="Default Image" 
                 class="img-fluid rounded mb-4"
                 style="max-width: 250px;">
        </div>

        <a href="login.php" class="btn btn-primary">Login</a>
        <a href="register.php" class="btn btn-secondary">Create Account</a>

    <?php endif; ?>

</main>

<?php require "includes/footer.php"; ?>
