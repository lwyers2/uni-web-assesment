<?php



include("includes/dbconn.php");

include("includes/functions.php");



$albums = " SELECT * FROM albumInfo";

$allAlbums = $conn->query($albums);

if (!$allAlbums) {
    echo $conn->error;
    exit();
}

include("../main/header.php");




?>



<div class="title">
    <h1>Filter By Artists</h1>
</div>

<?php

filterAlbums();
?>

<div class="filter-buttons">


    <button class="pseudo button" onclick="showHideAlphabetButtons()" id="alphabet-button">Alphabet</button>
    <button class="pseudo button" onclick="showHideFilterButtons('Artist')" id="artist-button">Show All Artists</button>




</div>

<div class="filter-choice-buttons">

    <div class="alphabet-buttons" id="alphabet-show" style="display: none">
        <?php
        alphabetButtons("artist");
        ?>

    </div>

    <div class="artist-buttons" id="filter-show" style="display: none">
        <?php
        artistButtons();
        ?>
    </div>
</div>

<div class="show-albums" id="hidden">

    <div class="choice-title">
        <h2 id="choice">Albums</h2>
    </div>
    <div class="album-container">


        <?php




        showFilteredAlbumArtist();




        ?>

    </div>
</div>
</div>



<script src="js/app.js">

</script>
</body>

</html>