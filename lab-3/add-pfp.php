<?php

// note: I had to getg help from searching some of my issues online, this included video(s), search enginge, and error fixes from ai

// Require login
require "includes/auth.php";

// Connect to database
require "includes/connect.php";

// Show admin-style header/navigation
require "includes/header_admin.php";

// Error + success messages
$errors = [];
$success = "";

// Set default to null
$imagePath = null;

// Get logged in user ID
$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    header("Location: restricted.php");
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Check if a file was uploaded
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] !== UPLOAD_ERR_NO_FILE) {

        // Check for upload errors
        if ($_FILES['profile_image']['error'] !== UPLOAD_ERR_OK) {
            $errors[] = "There was a problem uploading your file.";
        } else {

            // Allowed image types
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];

            // Detect real MIME type
            $detectedType = mime_content_type($_FILES['profile_image']['tmp_name']);

            if (!in_array($detectedType, $allowedTypes, true)) {
                $errors[] = "Only JPG, PNG, and WebP images are allowed.";
            } else {

                // Get file extension
                $extension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);

                // Create unique filename
                $safeFilename = uniqid('pfp_', true) . '.' . strtolower($extension);

                // Destination path
                $destination = __DIR__ . '/uploads/' . $safeFilename;

                // Move file to uploads folder
                if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $destination)) {

                    // Relative path for displaying the image
                    $imagePath = 'uploads/' . $safeFilename;

                    // Save to database
                    $sql = "UPDATE users SET profile_image = :img WHERE id = :id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':img', $imagePath);
                    $stmt->bindParam(':id', $userId);
                    $stmt->execute();

                    $success = "Profile picture uploaded successfully!";
                } else {
                    $errors[] = "Failed to save uploaded image.";
                }
            }
        }
    } else {
        $errors[] = "Please select an image to upload.";
    }
}
?>

<main class="container mt-4">
    <h1>Upload Profile Picture</h1>

    <!-- Error messages -->
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

    <!-- Success message -->
    <?php if ($success !== ""): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($success); ?>
        </div>

        <!-- Display uploaded image -->
        <?php if ($imagePath): ?>
            <div class="mt-3">
                <h4>Your Uploaded Image:</h4>
                <img src="<?= htmlspecialchars($imagePath); ?>" 
                     alt="Profile Picture" 
                     class="img-fluid" 
                     style="max-width: 300px;">
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Upload form -->
    <form method="post" enctype="multipart/form-data" class="mt-3">

        <label for="profile_image" class="form-label">Choose Profile Picture</label>
        <input
            type="file"
            id="profile_image"
            name="profile_image"
            class="form-control mb-4"
            accept=".jpg,.jpeg,.png,.webp"
            required
        >

        <button type="submit" class="btn btn-primary">Upload Image</button>
    </form>
</main>

<?php require "includes/footer.php"; ?>
