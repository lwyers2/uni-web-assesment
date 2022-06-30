<?php


include("../main/header.php");
include("includes/functions.php");

//only allows signed in ADMIN users entry
if ((!isset($_SESSION['userid'])) && (!$_SESSION['userTypeId'] == 0)) {
    header("location: ../../main/index.php");
    exit();
}


?>


<div class="all-users-show">

    <h1>Update User Accounts</h1>

    <?php

    showAllUsers();
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "invalidemail") {
            echo "<p>Invalid Email</p>";
        } elseif ($_GET["error"] == "invalidusername") {
            echo "<p>Invalid Username</p>";
        } elseif ($_GET["error"] == "invalidpwd") {
            echo "<p>Invalid Password</p>";
        }
    }


    if (isset($_GET["success"])) {
        if ($_GET["success"] == "email") {
            echo "<p>Email Updated!</p>";
        } elseif ($_GET["success"] == "username") {
            echo "<p>Username Updated!</p>";
        } elseif ($_GET["success"] == "pwd") {
            echo "<p>Password Updated!</p>";
        } elseif ($_GET['success'] == 'name') {
            echo "<p>Name Updated</p>";
        } elseif ($_GET['success'] == "delete") {
            echo "<p>Account Deleted</p>";
        }
    }

    ?>





</div>

</div>








<script src="js/app.js"> </script>
</body>

</html>