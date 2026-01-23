<?php
    /* What's the Problem? 
        - PHP logic + HTML in one file
        - Works, but not scalable
        - Repetition will become a problem

        How can we refactor this code so it’s easier to maintain?

        I knew I had to seperate the files, but I wasn't sure how to do it. I tried looking back at our incalss work where the files were separated into footer, header etc... But I wasn't getting the layout very much, so I did do some research to aid my understanding.

        One thing I learned from this lab is the importance of knowing how to organize files in a maintainable way. By separating the header, footer, and menu into their own files, it makes it easier to update and manage the code in the future. This approach also promotes reusability, as these components can be included in multiple pages without repeating code which should be our priorety to be DRY. I'm still not confident with the layout of these files and how to properly seperate and organize them, but I see the importance, and hopefulyl I will get better in future classes:). 
    */

   
$items = ["Home", "About", "Contact"];
include '../views/layout.php';


?>

<!-- <!DOCTYPE html>
<html>
    <head>
        <title>My PHP Page</title>
    </head>
    <body>

    <h1>Welcome</h1> Moved to header.php 

    <ul>
    <?php foreach ($items as $item): ?>
        <li><?= $item ?></li>
    <?php endforeach; ?>
    </ul> Moved to menu.php 

    <footer>
        <p>&copy; 2026</p>
    </footer> Moved to footer.php

    </body>
</html> 
-->
