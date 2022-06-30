<?php


include("../main/header.php");
include("includes/functions.php");

//only allows signed in users entry
if (!isset($_SESSION['userid'])) { #
    header("location: ../main/index.php");
    exit();
}
?>




<div class="my-info">
    <h1>Edit Info</h1>


</div>
<?php

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
    }
}
?>

<div class="choice">
    <!-- Added in required for all fields for simple validation - backen also checks input-->
    <button onclick="editBox('name')">Name</button>
    <button onclick="editBox('username')">Username</button>
    <button onclick="editBox('email')">Email</button>
    <button onclick="editBox('password')">Password</button>
    <a href="index.php"><button>Profile Info</button></a>


</div>
<div class="edit-name" style="display:none">
    <h2>Edit Name</h2>
    <div class="edit-container">
        <!-- Added in required for all fields for simple validation - backen also checks input-->
        <form action="includes/update-info.inc.php" method="post">
            <input type="text" name="name" required>
            <input type="submit" name="confirm" value="Confirm Changes">
        </form>
    </div>

</div>

<div class="edit-username" style="display:none">
    <h2>Edit UserName</h2>
    <div class="edit-container">
        <!-- Added in required for all fields for simple validation - backen also checks input-->
        <form action="includes/update-info.inc.php" method="post">
            <input type="text" name="username" required>
            <input type="submit" name="confirm" value="Confirm Changes">
        </form>



    </div>
</div>

<div class="edit-email" style="display:none">
    <h2>Edit Email</h2>
    <div class="edit-container">
        <!-- Added in required for all fields for simple validation - backen also checks input-->
        <form action="includes/update-info.inc.php" method="post">
            <input type="email" name="email" required>
            <input type="submit" name="confirm" value="Confirm Changes">
        </form>



    </div>
</div>


<div class="edit-password" style="display:none">
    <h2>Edit Password</h2>
    <div class="edit-container">
        <!-- Added in required for all fields for simple validation - backen also checks input-->
        <form action="includes/update-info.inc.php" method="post">
            <input type="password" name="pwd" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required placeholder="Create Password">
            <input type="password" name="pwd-conf" placeholder="Confirm Password" required>
            <input type="submit" name="confirm" value="Confirm Changes">
        </form>



    </div>
</div>



</div>






<script src="js/app.js"> </script>
</body>

</html>