<?php
session_start();
include("../main/includes/functions.php");


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rockin' Reviews</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/picnic">
    <script src="https://kit.fontawesome.com/39590b0325.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>





    <div class="container">
        <nav class="demo">
            <a href="/rockin-reviews/main/index.php" class="brand">

                <span>Rockin' Reviews</span>

            </a>
            <?php
            if (isset($_SESSION["userid"])) {
                echo "<span>Signed In As: " . $_SESSION["useruid"] . "</span>";
            }
            ?>



            <!-- responsive-->
            <input id="bmenub" type="checkbox" class="show">
            <label for="bmenub" class="burger pseudo button">menu</label>

            <div class="menu">
                <a href="../album-filter/index.php" class="pseudo button icon-picture">Albums</a>
                <a href="../search-albums/index.php" class="pseudo button icon-picture">Search</a>
                <?php
                //check if user is signed in to show 'Profile page' && decides which profile page can be seen.
                if (isset($_SESSION["useruid"]) && ($_SESSION['userTypeId'] == 1)) {
                    echo "<a href='../profile/index.php' class='pseudo button icon-picture'>Profile</a>";
                    echo "<a href='../main/includes/logout.inc.php' class='pseudo button icon-picture'>Log Out</a>";
                } elseif (isset($_SESSION["useruid"]) && ($_SESSION['userTypeId'] == 0)) {
                    echo "<a href='../profile/index.php' class='pseudo button icon-picture'>Profile</a>";
                    echo "<a href='../admin-profile/index.php' class='pseudo button icon-picture'>Admin Profile</a>";
                    echo "<a href='../main/includes/logout.inc.php' class='pseudo button icon-picture'>Log Out</a>";
                } else {
                    echo '<a href="../main/login.php" class="pseudo button icon-picture">Login</a>';
                    echo '<a href="../main/signup.php" class="pseudo button icon-picture">Sign Up</a>';
                }

                ?>


            </div>
        </nav>