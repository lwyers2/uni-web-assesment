<?php

include("includes/dbconn.php");

include("includes/functions.php");




include("../main/header.php");



?>



<div class="title">
    <h1>Filter By SubGenre</h1>
</div>

<?php
filterAlbums();
?>

<div class="filter-buttons">

    <button class="pseudo button" onclick="showHideAlphabetButtons()" id="alphabet-button">Alphabet</button>
    <button class="pseudo button " onclick="showHideFilterButtons('SubGenres')" id="filter-button">Show All SubGenres</button>



</div>

<div class="filter-choice-buttons">

    <div class="alphabet-buttons" id="alphabet-show" style="display: none">
        <?php
        alphabetButtons("subgenre");
        ?>

    </div>

    <div class="artist-buttons" id="filter-show" style="display: none">
        <?php
        subGenreButtons();
        ?>
    </div>
</div>

<div class="show-albums" id="hidden">


    <div class="choice-title">
        <h2 id="choice">Albums</h2>
    </div>
    <div class="album-container">


        <?php




        showFilteredAlbumSubGenre();




        ?>

    </div>
</div>
</div>



<script src="js/app.js"> </script>
</body>

</html>