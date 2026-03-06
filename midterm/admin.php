<?php
require "connect.php";
// Fetch all reviews from the database, ordered by most recent
$sql = "SELECT * FROM reviews ORDER BY created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="container mt-4">
  <!-- Title -->
  <h1>Reviews</h1>
  <!-- Check if there are any reviews -->
  <?php if (count($reviews) === 0): ?>
    <p>No reviews yet.</p>
  <?php else: ?>
    <!-- If yes... -->
    <table class="table table-bordered mt-3">
      <thead>
        <!-- Make a dynamic table -->
        <tr>
          <th>ID</th>
          <th>Book Name</th>
          <th>Author</th>
          <th>Rating</th>
          <th>Review</th>
          <th>Created At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <!-- Loop through each review and fill the dynamic table -->
        <?php foreach ($reviews as $review): ?>
          <tr>
            <td><?= htmlspecialchars($review['id']) ?></td>
            <td><?= htmlspecialchars($review['title']) ?></td>
            <td><?= htmlspecialchars($review['author']) ?></td>
            <td><?= htmlspecialchars($review['rating']) ?></td>
            <td><?= htmlspecialchars($review['review_text']) ?></td>
            <td><?= htmlspecialchars($review['created_at']) ?></td>
            <td>
                <!-- Sends the ID to update.php -->
                <a
                  class="btn btn-sm btn-warning"
                  href="update.php?id=<?= urlencode($review['id']); ?>">
                  Update
                </a>
                <!-- Sends the ID to delete.php -->
                <a
                  class="btn btn-sm btn-danger mt-2"
                  href="delete.php?id=<?= urlencode($review['id']); ?>"
                  onclick="return confirm('Are you sure you want to delete this review?');">
                  Delete
                </a>
              </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

  <!-- Back to Index Link -->
  <p class="mt-3">
    <a href="index.php">Back to Book Reviews</a>
  </p>
</main>

