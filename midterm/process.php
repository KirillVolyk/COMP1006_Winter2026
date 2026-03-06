<?php
require "connect.php";

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request");
}

// Sanitize input
$title   = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS));
$author   = trim(filter_input(INPUT_POST, 'author', FILTER_SANITIZE_SPECIAL_CHARS));
$rating   = filter_input(INPUT_POST, 'rating', FILTER_VALIDATE_INT);
$review_text   = trim(filter_input(INPUT_POST, 'review_text', FILTER_SANITIZE_SPECIAL_CHARS));

$errors = [];

// Server Side Validation (Empty checks, special characters checks, allow only certain characters, etc.)
// Checks title for ONLY having letters, numbers, and spaces (no special characters)
if (!preg_match('/^[a-zA-Z0-9\s]+$/', $title)) {
    $errors[] = "Book title is required and must only contain letters, numbers, and spaces.";
}
// Checks author for ONLY having letters, numbers, and spaces (no special characters)
if (!preg_match('/^[a-zA-Z0-9\s]+$/', $author)) {
    $errors[] = "Author name is required and must only contain letters, numbers, and spaces.";
}
// Checks rating is a number between 1 and 5
if ($rating === false || $rating < 1 || $rating > 5) {
    $errors[] = "Rating must be a number between 1 and 5.";
}
// Checks review text is not empty
if ($review_text === '' || $review_text === null) {
    $errors[] = "Review is required.";
}
// If errors, show them
if (!empty($errors)) {

    echo "<div class='alert alert-danger'>";
    echo "<h2>Please fix the following:</h2><ul>";
    foreach ($errors as $e) {
        echo "<li>" . htmlspecialchars($e) . "</li>";
    }
    echo "</ul></div>";
    exit;
}

// Insert into DB
$sql = "INSERT INTO reviews 
        (title, author, rating, review_text)
        VALUES 
        (:title, :author, :rating, :review_text)";

$stmt = $pdo->prepare($sql);

$stmt->bindParam(':title', $title);
$stmt->bindParam(':author', $author);
$stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
$stmt->bindParam(':review_text', $review_text);

$stmt->execute();

?>

<!-- Confirmation -->
<div class="alert alert-success">
    <h2>Review Submitted!</h2>
    <p>Your review for <strong><?= htmlspecialchars($title) ?></strong> has been added.</p>
</div>

<p><a href="admin.php">View Reviews</a></p>
