<?php


include("../main/header.php");
include("includes/functions.php");

//only allows signed in ADMIN users entry
if ((!isset($_SESSION['userid'])) && (!$_SESSION['userTypeId'] == 0)) {
    header("location: ../main/index.php");
    exit();
}

if (!isset($_POST['userid'])) {
    header("location: ../../main/index.php");
} else {
    $userId = $_POST['userid'];
}
?>




<div class="my-info">
    <h1>Edit Info</h1>


</div>


<div class="choice">
    <!-- Added in required for all fields for simple validation - backen also checks input-->
    <button onclick="editBox('name')">Name</button>
    <button onclick="editBox('username')">Username</button>
    <button onclick="editBox('email')">Email</button>
    <button onclick="editBox('password')">Password</button>
    <a href="users-admin.php"><button>Back</button></a>


</div>
<div class="edit-name" style="display:none">
    <h2>Edit Name</h2>
    <div class="edit-container">
        <!-- Added in required for all fields for simple validation - backen also checks input-->
        <form action="includes/user-update.inc.php" method="post">
            <input type="hidden" name="userid" value="<?php echo $userId ?>">
            <input type="text" name="name" required>
            <input type="submit" name="confirm" value="Confirm Changes">
        </form>
    </div>

</div>

<div class="edit-username" style="display:none">
    <h2>Edit UserName</h2>
    <div class="edit-container">
        <!-- Added in required for all fields for simple validation - backen also checks input-->
        <form action="includes/user-update.inc.php" method="post">
            <input type="hidden" name="userid" value="<?php echo $userId ?>">
            <input type="text" name="username" required>
            <input type="submit" name="confirm" value="Confirm Changes">
        </form>



    </div>
</div>

<div class="edit-email" style="display:none">
    <h2>Edit Email</h2>
    <div class="edit-container">
        <!-- Added in required for all fields for simple validation - backen also checks input-->
        <form action="includes/user-update.inc.php" method="post">
            <input type="hidden" name="userid" value="<?php echo $userId ?>">
            <input type="email" name="email" required>
            <input type="submit" name="confirm" value="Confirm Changes">
        </form>



    </div>
</div>


<div class="edit-password" style="display:none">
    <h2>Edit Password</h2>
    <div class="edit-container">
        <!-- Added in required for all fields for simple validation - backen also checks input-->
        <form action="includes/user-update.inc.php" method="post">
            <input type="hidden" name="userid" value="<?php echo $userId ?>">
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