<?php

include("header.php");

?>
<div class="signup">
    <div class="title">
        <h2>Log In</h2>
    </div>

    <div class="signup-form">
        <form action="includes/login.inc.php" method="post">
            <input type="text" name="uid" placeholder="Username/Email">
            <input type="password" name="pwd" placeholder="Password...">
            <button type="submit" name="submit" class="pseudo button icon-picture">Log In</button>
        </form>
    </div>

    <?php

    if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyinput") {
            echo "<p>Fill in all fields!</p>";
        } elseif ($_GET["error"] == "wronglogin") {
            echo "<p>Incorrect login information!</p>";
        }
    }

    ?>

</div>

</div>
</div>

</body>

</html>