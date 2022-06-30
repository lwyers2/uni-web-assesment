<?php


include("../main/header.php");
include("includes/functions.php");

//only allows signed in ADMIN users entry
if ((!isset($_SESSION['userid'])) && (!$_SESSION['userTypeId'] == 0)) {
    header("location: ../../main/index.php");
    exit();
}

if ($_GET) {

    if (isset($_GET["searchId"])) {

        if ($_GET['searchId'] == '') {

            echo "Invalid search";
        } else {



            $searchId = ($_GET["searchId"]);
            $searchId = strtolower($searchId);
        }
    }
}

?>


<div class="album-title">

    <h1>Search albums to Update</h1>
</div>







<form action="albums-admin.php" method="get">
    <div class="search-bar">
        <input type="text" placeholder="Search Albums" name="searchId" id="search-value">
        <button type="submit" class="pseudo button" onclick="updateSpaces()"><i class="fa fa-search"></i></button>
    </div>

</form>
<div class="show-hide-result-button">
    <button onclick="showHideButton('artist')" id="artist-button" class="pseudo button">Hide Artist Results</button>
    <button onclick="showHideButton('album')" id="album-button" class="pseudo button">Hide Album Results</button>
    <button onclick="showHideButton('genre')" id="genre-button" class="pseudo button">Hide Genre Results</button>
    <button onclick="showHideButton('subgenre')" id="subgenre-button" class="pseudo button">Hide SubGenre Results</button>
    <button onclick="showHideButton('year')" id="year-button" class="pseudo button">Hide Year Results</button>
    <button onclick="showHideAll()" id="show-button" class="pseudo button">Hide All</button>
</div>

<div class="results" id="all-result">
    <h1 id="results-title">Results</h1>
    <div class="artists" id="artist">
        <h2>Artists</h2>
        <div class="album-container">


            <?php



            if (isset($_GET["searchId"])) {
                if ($_GET['searchId'] == '') {

                    echo "Invalid search";
                } else {
                    showSearchedAlbumArtistEdit($searchId);
                }
            }
            ?>
        </div>
    </div>
    <div class="albums" id="album">
        <h2>Albums</h2>
        <div class="album-container">
            <?php



            if (isset($_GET["searchId"])) {
                if ($_GET['searchId'] == '') {

                    echo "Invalid search";
                } else {
                    showSearchedAlbumAlbumEdit($searchId);
                }
            }
            ?>
        </div>

    </div>
    <div class="genres" id="genre">
        <h2>Genres</h2>
        <div class="album-container">

            <?php



            if (isset($_GET["searchId"])) {
                if ($_GET['searchId'] == '') {

                    echo "Invalid search";
                } else {
                    showSearchedAlbumGenreEdit($searchId);
                }
            }
            ?>

        </div>

    </div>
    <div class="subgenres" id="subgenre">
        <h2>SubGenres</h2>
        <div class="album-container">
            <?php



            if (isset($_GET["searchId"])) {
                if ($_GET['searchId'] == '') {

                    echo "Invalid search";
                } else {
                    showSearchedAlbumSubGenreEdit($searchId);
                }
            }
            ?>
        </div>
    </div>
    <div class="years" id="year">
        <h2>Years</h2>
        <div class="album-container">
            <?php



            if (isset($_GET["searchId"])) {
                if ($_GET['searchId'] == '') {

                    echo "Invalid search";
                } else {
                    showSearchedAlbumYearEdit($searchId);
                }
            }
            ?>
        </div>
    </div>
</div>


</div>



<script src="js/app.js">

</script>
</body>

</html>





</div>

</div>








<script src="js/app.js"> </script>
</body>

</html>