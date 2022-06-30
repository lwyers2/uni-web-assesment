<?php

include("header.php");

?>
<div class="signup">
    <div class="title">
        <h2>Sign Up</h2>
    </div>

    <div class="signup-form">
        <form action="includes/signup.inc.php" method="post">
            <input type="text" name="name" placeholder="Full name...">
            <input type="text" name="email" placeholder="Email...">
            <input type="text" name="uid" placeholder="Username...">
            <input type="password" name="pwd" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required placeholder="Create Password">
            <input type="password" name="pwdrepeat" placeholder="Repeat Password...">
            <button type="submit" name="submit" class="pseudo button icon-picture">Register</button>
        </form>
    </div>

    <?php

    if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyinput") {
            echo "<p>Fill in all fields!</p>";
        } elseif ($_GET["error"] == "invalidUid") {
            echo "<p>Choose a proper username!</p>";
        } elseif ($_GET["error"] == "invalidEmail") {
            echo "<p>Choose a proper email!</p>";
        } elseif ($_GET["error"] == "passwordsdontmatch") {
            echo "<p>Passwords don't match!</p>";
        } elseif ($_GET["error"] == "stmtfailed") {
            echo "<p>Something went wrong</p>";
        } elseif ($_GET["error"] == "usernametaken") {
            echo "<p>Username taken, try a different username!</p>";
        }
    }


    if (isset($_GET["success"])) {


        if (($_GET["success"] == 's')) {
            echo "<p>You have signed up!</p>
        <a href='login.php' class='button'>Go To Login</a>";
        }
    }

    ?>

</div>

</div>
</div>

</body>

</html>