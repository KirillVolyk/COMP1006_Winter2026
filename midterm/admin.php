<?php
require "connect.php";

$sql = "SELECT * FROM reviews ORDER BY reviewed_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="container mt-4">
  <h1>Reviews</h1>

  <?php if (count($reviews) === 0): ?>
    <p>No reviews yet.</p>
  <?php else: ?>
    <table class="table table-bordered mt-3">
      <thead>
        <tr>
          <th>ID</th>
          <th>Book Name</th>
          <th>Author</th>
          <th>Rating</th>
          <th>Review</th>
          <th>Reviewed At</th>
          <th>Tasked At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        
        <?php foreach ($reviews as $review): ?>
          <tr>
            <td><?= htmlspecialchars($review['review_id']) ?></td>
            <td><?= htmlspecialchars($review['book_name']) ?></td>
            <td><?= htmlspecialchars($review['book_author']) ?></td>
            <td><?= htmlspecialchars($review['book_rating']) ?></td>
            <td><?= htmlspecialchars($review['book_review']) ?></td>
            <td><?= htmlspecialchars($review['reviewed_at']) ?></td>
            <td><?= htmlspecialchars($review['tasked_at']) ?></td>
            <td>
                <!-- Sends the ID to update.php -->
                <a
                  class="btn btn-sm btn-warning"
                  href="update.php?reviews_id=<?= urlencode($review['review_id']); ?>">
                  Update
                </a>
                <a
                  class="btn btn-sm btn-danger mt-2"
                  href="delete.php?reviews_id=<?= urlencode($review['review_id']); ?>"
                  onclick="return confirm('Are you sure you want to delete this review?');">
                  Delete
                </a>
              </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

  <p class="mt-3">
    <a href="index.php">Back to Book Reviews</a>
  </p>
</main>

