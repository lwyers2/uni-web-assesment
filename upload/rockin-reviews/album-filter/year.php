<?php

include("includes/dbconn.php");

include("includes/functions.php");


include("../main/header.php");



?>



<div class="title">
    <h1>Filter By Year</h1>
</div>

<?php
filterAlbums();
?>

<div class="filter-buttons">

    <button class="pseudo button" onclick="showHideDecadeButtons()" id="decade-button">Decade</button>
    <button class="pseudo button" onclick="showHideYearButtons()" id="year-button">Years</button>



</div>

<div class="filter-choice-buttons">

    <div class="decade-buttons" id="decade-show" style="display: none">
        <?php

        decadeButtons();



        ?>


    </div>

    <div class="year-buttons" id="year-show" style="display: none">
        <?php
        if ($_GET) {

            if (isset($_GET["decadeId"])) {
                $decadeId = $_GET['decadeId'];
                yearButtons($decadeId);
            }
        }
        ?>
    </div>


</div>

<div class="show-albums" id="hidden">


    <div class="choice-title">
        <h2 id="choice">Albums</h2>
    </div>
    <div class="album-container">


        <?php




        showFilteredAlbumYear();




        ?>

    </div>
</div>
</div>



<script src="js/app.js"> </script>
</body>

</html>