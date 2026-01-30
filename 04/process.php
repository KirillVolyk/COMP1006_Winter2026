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
$phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);
$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
//$items = filter_input(INPUT_POST, 'items', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
$items = $_POST['items'] ?? []; // fallback to empty array if not set

// validation time - server side validation
$errors = [];

//require text fields
if ($firstName === null || $firstName === '') {
    $errors[] = "First name is required.";
}

if ($lastName === null || $lastName === '') {
    $errors[] = "Last name is required.";
}

//required email and validation of format
if ($email === null || $email === '') {
    $errors[] = "An email address is required.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Email address format is invalid.";
}

//required address field
if ($address === null || $address === '') {
    $errors[] = "Address is required.";
}

$itemsOrdered = [];
//check that the order quantity is a number
foreach($items as $item => $quantity) {
    if(filter_var($quantity, FILTER_VALIDATE_INT) !== false && $quantity > 0) {
        $itemsOrdered[$item] = $quantity;
    } 
}

if(count($itemsOrdered) === 0) {
    $errors[] = "You must order at least one item.";
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


<main>
    <?php echo "<h2> Order Confirmation for " . $firstName . " " . $lastName . "</h2>"; ?>
    <section>
        <h3> Customer Information </h3>
        <ul>
            <?php
            echo "<li> Phone Number: " . $phone . "</li>";
            echo "<li> Address: " . $address . "</li>";
            echo "<li> Email: " . $email . "</li>";
            ?>
        </ul>
        <h3> Ordered Items</h3>
        <ul>
        <?php foreach($items as $item => $quantity): ?>
            <li><?php= $item ?>== <?= $quantity ?></li>
        <?php endforeach; ?>
        </ul>
    </section>
</main>

<!-- send email using mail function 
mail($to, $subject, $message); -->

<?php
require "includes/footer.php";

?>