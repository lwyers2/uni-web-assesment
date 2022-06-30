<?php


session_start();

include("functions.php");



//only allows signed in ADMIN users entry
if ((!isset($_SESSION['userid'])) && (!$_SESSION['userTypeId'] == 0)) { #
    header("location: ../main/index.php");
    exit();
}

if ((isset($_POST['albumid'])) && isset($_POST['genre'])) {
} else {
    header("location: ../update-album.php");
    exit();
}

$albumId = $_POST['albumid'];
$genreName = $_POST['genre'];

// subgenre =1 
if ($_POST['sub'] == 0) {

    var_dump($_POST);

    if (isGenreRegistered($genreName)) {
        $genreId = getGenreId($genreName);
        addGenreToAlbum($genreId, $albumId);
        header("location: ../albums-edit-info.php?albumId=" . $albumId);
        exit();
    } else {
        registerGenre($genreName);

        $genreId = getGenreId($genreName);
        addGenreToAlbum($genreId, $albumId);
        header("location: ../albums-edit-info.php?albumId=" . $albumId);
        exit();
    }
} else if ($_POST['sub'] == 1) {


    if (isGenreRegistered($genreName)) {
        $genreId = getGenreId($genreName);
        addSubGenreToAlbum($genreId, $albumId);
        header("location: ../albums-edit-info.php?albumId=" . $albumId);
        exit();
    } else {
        registerGenre($genreName);
        $genreId = getGenreId($genreName);
        addSubGenreToAlbum($genreId, $albumId);
        header("location: ../albums-edit-info.php?albumId=" . $albumId);
        exit();
    }
}
