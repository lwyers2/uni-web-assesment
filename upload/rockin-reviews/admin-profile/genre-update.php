<?php


include("../main/header.php");
include("includes/functions.php");

//only allows signed in ADMIN users entry
if ((!isset($_SESSION['userid'])) && (!$_SESSION['userTypeId'] == 0)) {
    header("location: ../main/index.php");
    exit();
}

// check if album id is set - if not will go back to admin page
if (isset($_POST['albumId'])) {


    //get album id to show
    $albumId = $_POST['albumId'];
} else {
    //returns if user has typed in page into url
    header("location: index.php");
    exit();
}

if (isset($_POST['genre'])) {
    echo '
<div class="edit-choice">
    <div class="edit-album-title">
        <h1>Edit Genres</h1>';

    $albumName = getAlbumName($albumId);
    echo '<h2>' . $albumName . '</h2>';
    echo '</div>';
} elseif (isset($_POST['subgenre'])) {
    echo '
<div class="edit-choice">
    <div class="edit-album-title">
        <h1>Edit SubGenres</h1>';

    $albumName = getAlbumName($albumId);
    echo '<h2>' . $albumName . '</h2>';
    echo '</div>';
} else {
    //returns if user has typed in page into url
    header("location: index.php");
}

?>



<div class="allgenres">
    <table class=genre-table>
        <tr>
            <th>Genre Name</th>
            <th>Delete?</th>
        </tr>
        <?php
        if (isset($_POST['genre'])) {
            showAllGenres($albumId);
        } elseif (isset($_POST['subgenre'])) {
            showAllSubGenres($albumId);
        }
        ?>
    </table>
    <button onclick="addGenreBox()">Add Genre</button>
</div>





</div>
<script src="js/app.js"> </script>
</body>

</html>