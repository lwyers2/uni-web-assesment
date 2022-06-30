<?php



function showAll()
{
    include("dbconn.php");

    $albums = " SELECT * FROM albumInfo";

    $allAlbums = $conn->query($albums);

    if (!$allAlbums) {
        echo $conn->error;
        exit();
    }



    while ($row = $allAlbums->fetch_assoc()) {
        $albumName = $row['albumName'];
        $ranking = $row['ranking'];
        $albumCover = $row['albumImgUrl'];
        $albumId = $row['albumId'];


        echo "
            <div class='album'>#Rolling Stones Ranking:{$ranking}<a href='../show-album/index.php?albumId={$albumId}'><img src='$albumCover' width='250px' height='250px' alt='Album artwork for $albumName'></a><h4>{$albumName}</h4></p></div>";
    }
}




function artistButtons()
{


    include("dbconn.php");
    $artists = " SELECT * FROM artistInfo ORDER BY artistName;";

    $allArtists = $conn->query($artists);

    if (!$artists) {
        echo $conn->error;
        exit();
    }


    echo '<form action="artist.php" method="post">';
    while ($row = $allArtists->fetch_assoc()) {
        $artistName = $row['artistName'];
        $artistId = $row['artistInfoId'];




        echo "<a class='pseudo button' id='{$artistId}' href='artist.php?artistId=$artistId'>{$artistName}</a>";
    }
    echo '</form>';
}



function genreButtons()
{


    include("dbconn.php");
    $genres = "SELECT  DISTINCT genre.genreName, genre.genreId FROM albumInfo INNER JOIN albumGenre ON albumInfo.albumId=albumGenre.albumId INNER JOIN genre on albumGenre.genreId=genre.genreId ORDER BY genre.genreName;";

    $allGenres = $conn->query($genres);

    if (!$genres) {
        echo $conn->error;
        exit();
    }


    echo '<form action="artist.php" method="post">';
    while ($row = $allGenres->fetch_assoc()) {
        $genreName = $row['genreName'];
        $genreId = $row['genreId'];



        echo "<a class='pseudo button' id='{$genreId}' href='genre.php?genreId=$genreId'>{$genreName}</a>";
    }
    echo '</form>';
}



function subGenreButtons()
{
    include("dbconn.php");
    $subGenres = "SELECT  DISTINCT genre.genreName, genre.genreId FROM albumInfo INNER JOIN albumSubGenre ON albumInfo.albumId=albumSubGenre.albumId INNER JOIN genre ON albumSubGenre.genreId=genre.genreId ORDER BY genre.genreName;";

    $allSubGenres = $conn->query($subGenres);

    if (!$subGenres) {
        echo $conn->error;
        exit();
    }


    echo '<form action="subgenre.php" method="post">';
    while ($row = $allSubGenres->fetch_assoc()) {
        $genreName = $row['genreName'];
        $genreId = $row['genreId'];



        echo "<a class='pseudo button' id='{$genreId}' href='subgenre.php?genreId=$genreId'>{$genreName}</a>";
    }
    echo '</form>';
}



function alphabetButtons($filter)
{

    echo '<form action="' . $filter . '.php" method="post">';
    for ($i = 65; 90 >= $i; $i++) { // A-65, Z-90
        $alpha = chr($i);
        echo '<a class="pseudo button" id="filter-letter-' . strtolower($alpha) . '" href="' . $filter . '.php?letterId=' . $alpha . '">' . $alpha . '</a>';
    }
    echo '</form>';
}

function decadeButtons()
{
    echo '<form action="year.php" method="post">';
    for ($i = 1950; $i <= 2020; $i++) { // first record released in 1948

        if ($i % 10 == 0) {
            echo '<a class="pseudo button" id="' . $i . '" href="year.php?decadeId=' . $i . '">' . $i . '</a>';
        }
    }
    echo '</form>';
}

function yearButtons()
{

    if ($_GET) {

        if (isset($_GET["decadeId"])) {

            $decade = $_GET['decadeId'];

            $finish = $decade + 10;
            echo '<form action="year.php" method="post">';
            for ($i = $decade; $i < $finish; $i++) { // first record released in 1948

                $year = $i;
                echo '<a class="pseudo button" id="filter-year-' . $year . '" href="year.php?yearId=' . $year . '">' . $year . '</a>';
            }
            echo '</form>';
        }
    }
}

function showFilteredAlbumArtist()
{

    if ($_GET) {

        if (isset($_GET["artistId"])) {



            include("dbconn.php");
            $artistId = $conn->real_escape_string($_GET["artistId"]);
            $read = "SELECT * FROM albumInfo INNER JOIN artistInfo ON albumInfo.artistId= artistInfo.artistInfoId WHERE artistID='$artistId';";
            $result = $conn->query($read);



            if (!$result) {
                echo $conn->error;
                exit();
            }




            while ($row = $result->fetch_assoc()) {
                $albumName = $row['albumName'];
                $albumYear = $row['albumYear'];
                $albumCover = $row['albumImgUrl'];
                $artistName = $row['artistName'];
                $albumId = $row['albumId'];


                echo "
                <div class='album'><a href='../show-album/index.php?albumId={$albumId}'><img src='$albumCover' width='250px' height='250px' alt='Album artwork for $albumName'></a><p>$artistName<br>$albumName</p></div>";
            }
        } elseif (isset($_GET["letterId"])) {



            include("dbconn.php");
            $letterId = $conn->real_escape_string($_GET["letterId"]);
            $read = "SELECT * FROM albumInfo INNER JOIN artistInfo ON albumInfo.artistId= artistInfo.artistInfoId WHERE artistName LIKE '$letterId%';";
            $result = $conn->query($read);



            if (!$result) {
                echo $conn->error;
                exit();
            }


            while ($row = $result->fetch_assoc()) {
                $albumName = $row['albumName'];
                $albumYear = $row['albumYear'];
                $albumCover = $row['albumImgUrl'];
                $artistName = $row['artistName'];
                $albumId = $row['albumId'];


                echo "
    <div class='album'><a href='../show-album/index.php?albumId={$albumId}'><img src='$albumCover' width='250px' height='250px' alt='Album artwork for $albumName'></a><p>$artistName<br>$albumName</p></div>";
            }
        }
    }
}


function showFilteredAlbumGenre()
{
    if ($_GET) {

        if (isset($_GET["genreId"])) {



            include("dbconn.php");
            $genreId = $conn->real_escape_string($_GET["genreId"]);
            $read = "SELECT * FROM albumInfo INNER JOIN albumGenre ON albumInfo.albumId=albumGenre.albumId INNER JOIN genre on albumGenre.genreId=genre.genreId WHERE albumGenre.genreId={$genreId};";
            $result = $conn->query($read);



            if (!$result) {
                echo $conn->error;
                exit();
            }




            while ($row = $result->fetch_assoc()) {
                $albumName = $row['albumName'];
                $albumCover = $row['albumImgUrl'];
                $genreName = $row['genreName'];
                $albumId = $row['albumId'];


                echo "
                <div class='album'><a href='../show-album/index.php?albumId={$albumId}'><img src='$albumCover' width='250px' height='250px' alt='Album artwork for $albumName'></a>s<p>$genreName<br>$albumName</p></div>";
            }
        } elseif (isset($_GET["letterId"])) {



            include("dbconn.php");
            $letterId = $conn->real_escape_string($_GET["letterId"]);
            $read = "SELECT * FROM albumInfo INNER JOIN albumGenre ON albumInfo.albumId=albumGenre.albumId INNER JOIN genre on albumGenre.genreId=genre.genreId WHERE genreName LIKE '$letterId%';";
            $result = $conn->query($read);



            if (!$result) {
                echo $conn->error;
                exit();
            }


            while ($row = $result->fetch_assoc()) {
                $albumName = $row['albumName'];
                $albumYear = $row['albumYear'];
                $albumCover = $row['albumImgUrl'];
                $genreName = $row['genreName'];
                $albumId = $row['albumId'];


                echo "
    <div class='album'><a href='../show-album/index.php?albumId={$albumId}'><img src='$albumCover' width='250px' height='250px' alt='Album artwork for $albumName'></a><p>$genreName<br>$albumName</p></div>";
            }
        }
    }
}



function showFilteredAlbumSubGenre()
{
    if ($_GET) {

        if (isset($_GET["genreId"])) {



            include("dbconn.php");
            $genreId = $conn->real_escape_string($_GET["genreId"]);
            $read = "SELECT * FROM albumInfo INNER JOIN albumSubGenre ON albumInfo.albumId=albumSubGenre.albumId INNER JOIN genre on albumSubGenre.genreId=genre.genreId WHERE albumSubGenre.genreId={$genreId};";
            $result = $conn->query($read);



            if (!$result) {
                echo $conn->error;
                exit();
            }




            while ($row = $result->fetch_assoc()) {
                $albumName = $row['albumName'];
                $albumCover = $row['albumImgUrl'];
                $genreName = $row['genreName'];
                $albumId = $row['albumId'];


                echo "
                <div class='album'><a href='../show-album/index.php?albumId={$albumId}'><img src='$albumCover' width='250px' height='250px'></a><p>$genreName<br>$albumName</p></div>";
            }
        } elseif (isset($_GET["letterId"])) {



            include("dbconn.php");
            $letterId = $conn->real_escape_string($_GET["letterId"]);
            $read = "SELECT * FROM albumInfo INNER JOIN albumSubGenre ON albumInfo.albumId=albumSubGenre.albumId INNER JOIN genre ON albumSubGenre.genreId=genre.genreId WHERE genreName LIKE '$letterId%';";
            $result = $conn->query($read);



            if (!$result) {
                echo $conn->error;
                exit();
            }


            while ($row = $result->fetch_assoc()) {
                $albumName = $row['albumName'];
                $albumYear = $row['albumYear'];
                $albumCover = $row['albumImgUrl'];
                $genreName = $row['genreName'];
                $albumId = $row['albumId'];


                echo "
    <div class='album'><a href='../show-album/index.php?albumId={$albumId}'><img src='$albumCover' width='250px' height='250px' alt='Album artwork for $albumName'></a><p>$genreName<br>$albumName</p></div>";
            }
        }
    }
}

function showFilteredAlbumYear()
{
    if ($_GET) {

        if (isset($_GET["decadeId"])) {


            include("dbconn.php");
            $decade = $conn->real_escape_string($_GET['decadeId']);



            $num0 = $decade;
            $num1 = $decade + 1;
            $num2 = $decade + 2;
            $num3 = $decade + 3;
            $num4 = $decade + 4;
            $num5 = $decade + 5;
            $num6 = $decade + 6;
            $num7 = $decade + 7;
            $num8 = $decade + 8;
            $num9 = $decade + 9;



            $read = "SELECT * FROM albumInfo WHERE albumYear IN ('{$num0}','{$num1}}','{$num2}}','{$num3}}','{$num4}}','{$num5}}','{$num6}}','{$num7}}','{$num8}}','{$num9}}') ORDER BY albumYear; ";
            $result = $conn->query($read);



            if (!$result) {
                echo $conn->error;
                exit();
            }




            while ($row = $result->fetch_assoc()) {
                $albumName = $row['albumName'];
                $albumCover = $row['albumImgUrl'];
                $albumYear = $row['albumYear'];
                $albumId = $row['albumId'];


                echo "
                <div class='album'><a href='../show-album/index.php?albumId={$albumId}'><img src='$albumCover' width='250px' height='250px' alt='Album artwork for $albumName'></a><p>$albumYear<br>$albumName</p></div>";
            }
        } elseif (isset($_GET["yearId"])) {



            include("dbconn.php");
            $yearId = $conn->real_escape_string($_GET["yearId"]);
            $read = "SELECT * FROM albumInfo WHERE albumYear IN ('{$yearId}')";
            $result = $conn->query($read);



            if (!$result) {
                echo $conn->error;
                exit();
            }


            while ($row = $result->fetch_assoc()) {
                $albumName = $row['albumName'];
                $albumCover = $row['albumImgUrl'];
                $albumYear = $row['albumYear'];
                $albumId = $row['albumId'];

                echo "
                <div class='album'><a href='../show-album/index.php?albumId={$albumId}'><img src='$albumCover' width='250px' height='250px' alt='Album artwork for $albumName'></a><p>$albumYear<br>$albumName</p></div>";
            }
        }
    }
}

function filterAlbums()
{
    echo '
    <h3>Filter By:</h3>
    <div class="links">
        <a href="../album-filter/artist.php" class="pseudo button icon-picture">Artist</a>
        <a href="../album-filter/genre.php" class="pseudo button icon-picture">Genre</a>
        <a href="../album-filter/subgenre.php" class="pseudo button icon-picture">SubGenre</a>
        <a href="../album-filter/year.php" class="pseudo button icon-picture">Year</a>
    </div>
    ';
}
