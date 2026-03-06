<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Review Submission</title>
</head>
<body>

    <h1>Submit a Book Review</h1>

    <form action="process.php" method="POST">

        <label for="title">Book Title:</label>
        <input type="text" id="title" name="title" required>

        <label for="author">Author:</label>
        <input type="text" id="author" name="author" required>

        <label for="rating">Rating (1 to 5):</label>
        <input type="number" id="rating" name="rating" min="1" max="5" required>

        <label for="review_text">Review:</label>
        <textarea id="review_text" name="review_text" rows="6" cols="40" required></textarea>

        <button type="submit">Submit Review</button>

    </form>

    <p>
        <a href="admin.php">Go to Admin Page</a>
    </p>

</body>
</html>
