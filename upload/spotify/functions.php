<?php


function getArtistId($artistName)
{

    include("dbconn.php");

    $sql = "SELECT * FROM artistInfo WHERE artistName = ?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "ERROR";
    }


    mysqli_stmt_bind_param($stmt, "s", $artistName);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row['artistId'];
    } else {
    }



    mysqli_stmt_close($stmt);
}


function searchArt()
{
    include("dbconn.php");

    $sql = "SELECT * FROM albumInfo INNER JOIN artistInfo ON albumInfo.artistId=artistInfo.artistId";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "ERROR";
    }



    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    echo "<button onclick='run100()'>Run100</button>";
    echo "<button onclick='run200()'>Run200</button>";
    echo "<button onclick='run300()'>Run300</button>";
    echo "<button onclick='run400()'>Run400</button>";
    echo "<button onclick='run500()'>Run500</button>";

    $count1 = 1;
    $count2 = 1;
    $count3 = 1;
    $count4 = 1;
    $count5 = 1;


    echo '
    <script>
        function run100() {
            ';

    while ($row = mysqli_fetch_assoc($resultData)) {


        $albumName = $row['albumName'];
        $artistName = $row['artistName'];


        echo '
                searchAlbum("' . $albumName . '", "' . $artistName . '");

            ';
        $count1++;
        if ($count1 == 100) {
            break;
        }
    }

    echo '}
    </script>';


    echo '
    <script>
        function run200() {
            ';

    while ($row = mysqli_fetch_assoc($resultData)) {


        $ranking = $row['ranking'];
        $albumName = $row['albumName'];
        $artistName = $row['artistName'];

        if ($ranking > 100) {


            echo '
            searchAlbum("' . $albumName . '", "' . $artistName . '");

            ';
            $count2++;
            if ($count2 == 100) {
                break;
            }
        }
    }

    echo '}
    </script>';

    echo '
    <script>
        function run300() {
            ';

    while ($row = mysqli_fetch_assoc($resultData)) {


        $ranking = $row['ranking'];
        $albumName = $row['albumName'];
        $artistName = $row['artistName'];

        if ($ranking > 200) {


            echo '
            searchAlbum("' . $albumName . '", "' . $artistName . '");

            ';
            $count3++;
            if ($count3 == 100) {
                break;
            }
        }
    }

    echo '}
    </script>';

    echo '
    <script>
        function run400() {
            ';

    while ($row = mysqli_fetch_assoc($resultData)) {


        $ranking = $row['ranking'];
        $albumName = $row['albumName'];
        $artistName = $row['artistName'];

        if ($ranking > 300) {


            echo '
            searchAlbum("' . $albumName . '", "' . $artistName . '");

            ';
            $count4++;
            if ($count4 == 100) {
                break;
            }
        }
    }

    echo '}
    </script>';

    echo '
    <script>
        function run500() {
            ';

    while ($row = mysqli_fetch_assoc($resultData)) {


        $ranking = $row['ranking'];
        $albumName = $row['albumName'];
        $artistName = $row['artistName'];

        if ($ranking > 400) {


            echo '
            searchAlbum("' . $albumName . '", "' . $artistName . '");

            ';
            $count5++;
            if ($count4 == 500) {
                break;
            }
        }
    }

    echo '}
    </script>';



    mysqli_stmt_close($stmt);
}

function takeTwo()
{

    include("dbconn.php");

    $sql = "SELECT * FROM albumInfo INNER JOIN artistInfo ON albumInfo.artistId=artistInfo.artistId";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "ERROR";
    }


    $count = 1;
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($resultData)) {


        $albumName = $row['albumName'];
        $artistName = $row['artistName'];
        $albumId = $row['albumId'];

        $classAlbum = $albumName;
        $classAlbum = str_replace("'", "", $classAlbum);
        $classAlbum = str_replace(" ", "-", $classAlbum);
        $classAlbum = strtolower($classAlbum);

        echo '<div class="' . $classAlbum . '">UPDATE `albumInfo` SET `albumImgUrl` =  "</div>';
        echo '<div>" WHERE `albumInfo`.`albumId` = ' . $albumId . ';</div> <br>';
        $count++;
    }

    mysqli_stmt_close($stmt);
}


function getAlbumIdRank($ranking)
{
    include("dbconn.php");

    $sql = "SELECT * FROM albumInfo WHERE ranking = ?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "ERROR";
    }


    mysqli_stmt_bind_param($stmt, "i", $ranking);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row['albumId'];
    } else {
    }



    mysqli_stmt_close($stmt);
}


function getGenreId($genreName)
{
    include("dbconn.php");

    $sql = "SELECT * FROM genre WHERE genreName = ?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "ERROR";
    }


    mysqli_stmt_bind_param($stmt, "s", $genreName);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row['genreId'];
    } else {
    }



    mysqli_stmt_close($stmt);
}
