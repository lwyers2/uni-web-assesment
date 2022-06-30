<?php


include("../main/header.php");
include("includes/functions.php");

//only allows signed in ADMIN users entry
if ((!isset($_SESSION['userid'])) && (!$_SESSION['userTypeId'] == 0)) {
    header("location: ../main/index.php");
    exit();
}



// check if album id is set - if not will go back to admin page
if (isset($_GET['albumId'])) {


    //get album id to show
    $albumId = $_GET['albumId'];
} else {
    //returns if user has typed in page into url
    header("location: index.php");
    exit();
}
?>

<div class="album-title">
    <h1>Do you wish to edit or delete album?</h1>

</div>

<a href="albums-edit-info.php?albumId=<?php echo $albumId ?>"><button class="success">Edit</button></a>
<a href="includes/album-delete.inc.php?albumId=<?php echo $albumId ?>"><button class="error">Delete</button></a>
<a href="albums-admin.php"><button class="warning">Go Back</button></a>



<script src="js/app.js"> </script>
</body>

</html>