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

if ($_POST['sub'] == 0) {
    $genreId = getGenreId($genreName);
    deleteGenreFromAlbum($albumId, $genreId);
    header("location: ../albums-edit-info.php?albumId=" . $albumId);
    exit();
} elseif ($_POST['sub'] == 1) {
    $genreId = getGenreId($genreName);
    deleteSubGenreFromAlbum($albumId, $genreId);
    header("location: ../albums-edit-info.php?albumId=" . $albumId);
    exit();
}
