<?php require "includes/header.php" ?>
<main>
  <h2> Order Online - Easy & Simple (And Totally Secure...) 🧁</h2>
  <!-- start form -->
  <form action="process.php" method="post">

    <!-- Customer Information -->
    <fieldset>
      <legend>Customer Information</legend>
        <label for="first_name">First name</label>
        <input type="text" id="first_name" name="first_name" minlength=3 maxlength = 20 >
        <label for="last_name">Last name</label>
        <input type="text" id="last_name" name="last_name" minlength=3 maxlength = 20 >
        <label for="address">Address</label>
        <input type="address" id="address" name="address" minlength=6 maxlength = 25 >
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" minlength=6 maxlength = 30 >
    </fieldset>

    <!-- Additional Message -->
    <fieldset>
      <legend>Message</legend>

      <p>
        <label for="comments">Comments (optional)</label><br>
        <textarea id="comments" name="comments" rows="4"
          placeholder="Allergies, delivery instructions, custom messages..."></textarea>
      </p>
    </fieldset>

    <!-- Submit button -->
    <p>
      <button type="submit">Place Order</button>
    </p>

  </form>
</main>
</body>

</html>

<!-- include footer -->
<?php require "includes/footer.php" ?>