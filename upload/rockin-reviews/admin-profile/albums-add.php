<?php


include("../main/header.php");
include("includes/functions.php");

//only allows signed in ADMIN users entry
if ((!isset($_SESSION['userid'])) && (!$_SESSION['userTypeId'] == 0)) {
    header("location: ../main/index.php");
    exit();
}


?>

<div class="album-title">
    <h1>Add Album</h1>

</div>
<form action="includes/add-album.inc.php" method="post" style="width:50%">
    <label for="albumname">Album Name</label>
    <input type="text" name="albumname" require>
    <label for="rank">Rolling Stones Ranking</label>
    <input type="number" name="rank" require>
    <label for="artist">Artist Name</label>
    <input type="text" name="artist" require>
    <label for="year">Realease Date</label>
    <input type="number" name="year" require>
    <label for="genre">Genre</label>
    <input type="text" name="genre" require>
    <label for="subgenre">Sub Genre</label>
    <input type="text" name="subgenre" require>
    <input type="submit" class="success" value="Add Album">
    <input type="reset" class="button">

</form>
<a href="index.php"><button>Return</button></a>



</div>








<script src="js/app.js"> </script>
</body>

</html>