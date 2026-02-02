<?php
require "includes/header.php";

//echo "<p> Thank you for your order! </p> \n"; 

//access the form data and then echo on the page in cofnirmation message -->
// Wait no server side validation
// $firstName = $_POST['first_name'];
// $lastName = $_POST['last_name'];
// $phone = $_POST['phone'];
// $address = $_POST['address'];
// $email = $_POST['email'];
// $items = $_POST['items'];

// A better way!

// Sanitize the date - filter_input and validate - filter_var (proper email format, phono format, intager order quanitty) and logic to ensure user provide required input


// grab and sanitize customer information into variables
$firstName = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS);
$lastName = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS);
$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$comments = filter_input(INPUT_POST, 'comments', FILTER_SANITIZE_SPECIAL_CHARS);

// validation time - server side validation
$errors = [];

//require text fields
// first name
if ($firstName === null || $firstName === '') {
    $errors[] = "First name is required.";
}
// last name
if ($lastName === null || $lastName === '') {
    $errors[] = "Last name is required.";
}

//required email and validation of format
// email
if ($email === null || $email === '') {
    $errors[] = "An email address is required.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Email address format is invalid.";
}

//required address field
// address
if ($address === null || $address === '') {
    $errors[] = "Address is required.";
}

//loop through errors and display them
foreach ($errors as $error): ?>
    <li> <?php echo $error; ?> </li>
<?php endforeach;
//stop the script from excuting if there are errors
if (count($errors) > 0){
    exit;
}
?>

<!-- show customer info -->
<main>
    <section>
        <h3> Customer Information </h3>
        <ul>
            <?php
            echo "<li> First Name: " . $firstName . "</li>";
            echo "<li> Last Name: " . $lastName . "</li>";
            echo "<li> Address: " . $address . "</li>";
            echo "<li> Email: " . $email . "</li>";
            echo "<li> Message: " . $comments . "</li>";
            ?>
        </ul>
    </section>
</main>

<!-- send email using mail function doesn't work on local server but code should work on live server
mail($to, $subject, $message); -->
<?php
// send confirmation email to customer
$header = "From: no-reply@gmail.com\r\n";
mail($email, "Order Confirmation", "Thank you for your order, " . $firstName . "!", $header);
?>

<?php
require "includes/footer.php";

?>