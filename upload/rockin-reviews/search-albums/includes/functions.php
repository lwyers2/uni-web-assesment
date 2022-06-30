<?php

function showSearchedAlbumArtistAPI($searchAlbum)
{
    $endpoint = "http://lwyers01.webhosting6.eeecs.qub.ac.uk/rockin-reviews/api/api.php?q={$searchAlbum}&type=ar";

    $resource = file_get_contents($endpoint);

    $data = json_decode($resource, true);


    foreach ($data as $row) {


        //get information for populating album page details

        $albumName = $row['albumName'];
        $albumCover = $row['albumImgUrl'];
        $artistName = $row['artistName'];
        $albumId = $row['albumId'];

        if (strlen($albumName) > 30) {
            $albumName = substr($albumName, 0, 27) . "...";
        }

        if (strlen($artistName) > 30) {
            $artistName = substr($artistName, 0, 27) . "...";
        }


        echo "
        <div class='album'><a href='../show-album/index.php?albumId={$albumId}'><img src='$albumCover' width='250px' height='250px' alt='Album artwork for $albumName'></a><p>$artistName<br>$albumName</p></div>";
    }
}




function showSearchedAlbumAlbumAPI($searchAlbum)
{



    $endpoint = "http://lwyers01.webhosting6.eeecs.qub.ac.uk/rockin-reviews/api/api.php?q={$searchAlbum}&type=al";

    $resource = file_get_contents($endpoint);

    $data = json_decode($resource, true);


    foreach ($data as $row) {


        //get information for populating album page details

        $albumName = $row['albumName'];
        $albumCover = $row['albumImgUrl'];
        $albumYear = $row['albumYear'];
        $albumId = $row['albumId'];

        if (strlen($albumName) > 30) {
            $albumName = substr($albumName, 0, 27) . "...";
        }

        echo "
        <div class='album'><a href='../show-album/index.php?albumId={$albumId}'><img src='$albumCover' width='250px' height='250px' alt='Album artwork for $albumName'></a><p>$albumName<br>$albumYear</p></div>";
    }
}



function showSearchedAlbumGenreAPI($searchGenre)
{



    $endpoint = "http://lwyers01.webhosting6.eeecs.qub.ac.uk/rockin-reviews/api/api.php?q={$searchGenre}&type=g";

    $resource = file_get_contents($endpoint);

    $data = json_decode($resource, true);


    foreach ($data as $row) {


        //get information for populating album page details
        $albumName = $row['albumName'];
        $albumCover = $row['albumImgUrl'];
        $genreName = $row['genreName'];
        $albumId = $row['albumId'];

        if (strlen($albumName) > 30) {
            $albumName = substr($albumName, 0, 27) . "...";
        }

        echo "<div class='album'><a href='../show-album/index.php?albumId={$albumId}'><img src='$albumCover' width='250px' height='250px' alt='Album artwork for $albumName'></a><p>$albumName<br>$genreName</p></div>";
    }
}


function showSearchedAlbumSubGenreAPI($searchSubGenre)
{
    $endpoint = "http://lwyers01.webhosting6.eeecs.qub.ac.uk/rockin-reviews/api/api.php?q={$searchSubGenre}&type=s";

    $resource = file_get_contents($endpoint);

    $data = json_decode($resource, true);


    foreach ($data as $row) {


        //get information for populating album page details
        $albumName = $row['albumName'];
        $albumCover = $row['albumImgUrl'];
        $genreName = $row['genreName'];
        $albumId = $row['albumId'];

        if (strlen($albumName) > 30) {
            $albumName = substr($albumName, 0, 27) . "...";
        }

        echo "<div class='album'><a href='../show-album/index.php?albumId={$albumId}'><img src='$albumCover' width='250px' height='250px' alt='Album artwork for $albumName'></a><p>$albumName<br>$genreName</p></div>";
    }
}



function showSearchedAlbumYearAPI($searchYear)
{
    $endpoint = "http://lwyers01.webhosting6.eeecs.qub.ac.uk/rockin-reviews/api/api.php?q={$searchYear}&type=y";

    $resource = file_get_contents($endpoint);

    $data = json_decode($resource, true);


    foreach ($data as $row) {


        //get information for populating album page details
        $albumName = $row['albumName'];
        $albumCover = $row['albumImgUrl'];
        $albumYear = $row['albumYear'];
        $albumId = $row['albumId'];

        if (strlen($albumName) > 30) {
            $albumName = substr($albumName, 0, 27) . "...";
        }


        echo "
      <div class='album'><a href='../show-album/index.php?albumId={$albumId}'><img src='$albumCover' width='250px' height='250px' alt='Album artwork for $albumName'></a><p>$albumName<br>$albumYear</p></div>";
    }
}
