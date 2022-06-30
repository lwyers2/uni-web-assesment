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
    <h1>Filter By Genre</h1>
</div>
<?php

filterAlbums();
?>

<div class="filter-buttons">

    <button class="pseudo button" onclick="showHideAlphabetButtons()" id="alphabet-button">Alphabet</button>
    <button class="pseudo button " onclick="showHideFilterButtons('Genre')" id="filter-button">Show All Genres</button>



</div>

<div class="filter-choice-buttons">

    <div class="alphabet-buttons" id="alphabet-show" style="display: none">
        <?php
        alphabetButtons("genre");
        ?>

    </div>

    <div class="artist-buttons" id="filter-show" style="display: none">
        <?php
        genreButtons();
        ?>
    </div>
</div>

<div class="show-albums" id="hidden">


    <div class="choice-title">
        <h2 id="choice">Albums</h2>
    </div>
    <div class="album-container">


        <?php




        showFilteredAlbumGenre();




        ?>

    </div>
</div>
</div>



<script src="js/app.js"> </script>
</body>

</html>