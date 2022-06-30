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


<div class="my-favourite-owned">

    <h1>My Albums</h1>


</div>

<div class="album-choice">
    <button onclick='showHideChoice("owned")' id="owned-button">Show Owned</button>
    <button onclick='showHideChoice("favourite")' id="favourite-button">Show Favourite</button>

</div>

<div class="album">



    <div class="owned" id="owned" style="display:none">
        <h2>Owned</h2>
        <div class="album-container">
            <?php
            showOwned($userid);
            ?>
        </div>

    </div>
    <div class="favourite" id='favourite' style="display:none">
        <h2>Favourites</h2>
        <div class="album-container">
            <?php
            showFavourites($userid);
            ?>
        </div>
    </div>


</div>


<script src="js/app.js"> </script>
</body>

</html>