<?php
session_start();


include("functions.php");

//only allows signed in ADMIN users entry
if ((!isset($_SESSION['userid'])) && (!$_SESSION['userTypeId'] == 0) && (isset($_POST))) {
    header("location: ../main/index.php");
    exit();
}

if (isset($_POST)) {

    $name = $_POST['albumname'];
    $rank = $_POST['rank'];
    $artist = $_POST['artist'];
    $year = $_POST['year'];
    $genre = $_POST['genre'];
    $subgenre = $_POST['subgenre'];


    createAlbum($name, $rank, $artist, $year);

    $albumId = getAlbumId($name, $rank);

    if (isGenreRegistered($genre)) {
        $genreId = getGenreId($genre);
        addGenreToAlbum($genreId, $albumId);
    } else {
        registerGenre($genre);
        $genreId = getGenreId($genre);
        addGenreToAlbum($genreId, $albumId);
    }


    if (isGenreRegistered($subgenre)) {
        $genreId = getGenreId($subgenre);
        addSubGenreToAlbum($genreId, $albumId);
    } else {
        registerGenre($subgenre);
        $genreId = getGenreId($subgenre);
        addSubGenreToAlbum($genreId, $albumId);
    }

    header("location: ../index.php");
    exit();
}
