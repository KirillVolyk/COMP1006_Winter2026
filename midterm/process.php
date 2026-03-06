<?php
require "connect.php";

// 1. Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request");
}

// 2. Sanitize input
$bookName   = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS));
$bookAuthor   = trim(filter_input(INPUT_POST, 'author', FILTER_SANITIZE_SPECIAL_CHARS));
$bookRating   = filter_input(INPUT_POST, 'rating', FILTER_VALIDATE_INT);
$bookReview   = trim(filter_input(INPUT_POST, 'review_text', FILTER_SANITIZE_SPECIAL_CHARS));

$errors = [];

// 3. Server Side Validation (Empty checks, special characters checks, allow only certain characters, etc.)
if (!preg_match('/^[a-zA-Z0-9\s]+$/', $bookName)) {
    $errors[] = "Book title is required and must only contain letters, numbers, and spaces.";
}

if (!preg_match('/^[a-zA-Z0-9\s]+$/', $bookAuthor)) {
    $errors[] = "Author name is required and must only contain letters, numbers, and spaces.";
}

if ($bookRating === false || $bookRating < 1 || $bookRating > 5) {
    $errors[] = "Rating must be a number between 1 and 5.";
}

if ($bookReview === '' || $bookReview === null) {
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
        (book_name, book_author, book_rating, book_review)
        VALUES 
        (:book_name, :book_author, :book_rating, :book_review)";

$stmt = $pdo->prepare($sql);

$stmt->bindParam(':book_name', $bookName);
$stmt->bindParam(':book_author', $bookAuthor);
$stmt->bindParam(':book_rating', $bookRating, PDO::PARAM_INT);
$stmt->bindParam(':book_review', $bookReview);

$stmt->execute();

?>

<!-- 5. Confirmation -->
<div class="alert alert-success">
    <h2>Review Submitted!</h2>
    <p>Your review for <strong><?= htmlspecialchars($bookName) ?></strong> has been added.</p>
</div>

<p><a href="reviews.php">View Reviews</a></p>
