<?php
require "connect.php";

// 1. Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request");
}

// 2. Sanitize input
$title   = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS));
$author   = trim(filter_input(INPUT_POST, 'author', FILTER_SANITIZE_SPECIAL_CHARS));
$rating   = filter_input(INPUT_POST, 'rating', FILTER_VALIDATE_INT);
$review_text   = trim(filter_input(INPUT_POST, 'review_text', FILTER_SANITIZE_SPECIAL_CHARS));

$errors = [];

// 3. Server Side Validation (Empty checks, special characters checks, allow only certain characters, etc.)
if (!preg_match('/^[a-zA-Z0-9\s]+$/', $title)) {
    $errors[] = "Book title is required and must only contain letters, numbers, and spaces.";
}

if (!preg_match('/^[a-zA-Z0-9\s]+$/', $author)) {
    $errors[] = "Author name is required and must only contain letters, numbers, and spaces.";
}

if ($rating === false || $rating < 1 || $rating > 5) {
    $errors[] = "Rating must be a number between 1 and 5.";
}

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

// 4. Insert into DB
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

<!-- 5. Confirmation -->
<div class="alert alert-success">
    <h2>Review Submitted!</h2>
    <p>Your review for <strong><?= htmlspecialchars($title) ?></strong> has been added.</p>
</div>

<p><a href="reviews.php">View Reviews</a></p>
