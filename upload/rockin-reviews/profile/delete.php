<?php


include("../main/header.php");
include("includes/functions.php");

//only allows signed in users entry
if (!isset($_SESSION['userid'])) { #
    header("location: ../main/index.php");
    exit();
}

$userid = $_SESSION['userid'];

?>

<div class="confirm">
    <h1>Delete Profile</h1>

    <h2>Are you sure you want to delete your profile?</h2>
    <p>All Reveiws and Owned and Favourited albums will be deleted!!</p>


    <div class="yes-or-no">
        <form action="includes/delete.inc.php" method="post">
            <input type="submit" name="yes" value="Yes" id="yes">
        </form>
        <a href="index.php"><button>NO</button></a>
    </div>
</div>
</div>

<script src="js/app.js"> </script>
</body>

</html>