<?php
// ============================================
// Dad Joke API Demo - Search Version
// Instructor File for COMP1006
// ============================================
// This page shows how to:
// 1. collect user input from a form
// 2. send that input to an API as part of the URL
// 3. decode JSON results returned by the API
// 4. loop through multiple jokes and display them

//initialize search term variable to hold users' search term 
$searchTerm = "";
//intialize the $jokes variable to hold jokes returned 
$jokes = [];
//create a message variable to hold error/success message 
$message = "";

//check that the form is submitted 
if (isset($_POST['search_jokes'])) {
    //grab the search term entered
    $searchTerm = trim($_POST['search_term']);
    //validate that the user entered a search term 
    if ($searchTerm !== "") {
        //build the URL with search term appended 
        $url = "https://icanhazdadjoke.com/search?term=" . urlencode($searchTerm);

        //use headers to tell the API we want JSON returned
        $options = [
            "http" => [
                "method" => "GET",
                "header" => "Accept:application/json\r\n" .
                    "User-Agent: COMP1006 Dad Joke Demo (http://localhost)\r\n"
            ]
        ];

        //convert the options array into a stream context 
        $context = stream_context_create($options);

        //send the request to the search endpoint 
        $response = file_get_contents($url, false, $context);

        //check we get a response 
        if ($response !== false) {
            //convert the JSON response into a PHP associative array 
            $data = json_decode($response, true);
            //r_dump($data);
            $jokes = $data['results'];
            if (count($jokes) == 0) {
                $message = "Sorry, no jokes about that";
            }
        } else {
            $message = "Sorry, something wrong with the Dad Jokes API!";
        }
    } else {
        $message = "Please enter a search term";
    }
}

?>
<!--
        This form sends the user's search word back to this same page.
        PHP then uses that word to build the API request URL.
    -->
<form method="post">
    <label for="search_term">Enter a word:</label>
    <input
        type="text"
        name="search_term"
        id="search_term"
        value="<?php echo htmlspecialchars($searchTerm); ?>">
    <button type="submit" name="search_jokes">Search</button>
</form>

<?php if ($message != ""): ?>
    <p><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

<?php if (!empty($jokes)): ?>
    <h2>Results for "<?php echo htmlspecialchars($searchTerm); ?>"</h2>

    <ul>
        <?php foreach ($jokes as $joke): ?>
            <!--
                    Each item in the results array is itself an array.
                    The actual joke text is stored in the 'joke' field.
                -->
            <li><?php echo htmlspecialchars($joke['joke']); ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

</body>

</html>