<?php


session_start();

include("functions.php");


//only allows signed in ADMIN users entry
if ((!isset($_SESSION['userid'])) && (!$_SESSION['userTypeId'] == 0) && isset($_POST['albumId'])) { #
    // header("location: ../main/index.php");
    exit();
}

var_dump($_POST);

$albumId = $_POST['albumId'];

if (isset($_POST['rank'])) {
    $rank = $_POST['rank'];
    updateRank($albumId, $rank);
    header("location: ../albums-edit-info.php?edit=rank");
    exit();
} elseif (isset($_POST['cover'])) {
    $cover = $_POST['cover'];
    updateCover($albumId, $cover);
    header("location: ../albums-edit-info.php?edit=cover");
} elseif (isset($_POST['artist'])) {
    //check if artist exists in db, if not add then retrieve artist id
    $artistName = $_POST['artist'];

    if (isRegisteredArtist($artistName)) {
        $artistId = getArtistId($artistName);
        updateArtist($albumId, $artistId);
        header("location: ../albums-edit-info.php?edit=artist");
        exit();
    } else {
        registerArtist($artistName);
        $artistId = getArtistId($artistName);
        updateArtist($albumId, $artistId);
        header("location: ../albums-edit-info.php?edit=artist");
        exit();
    }
} elseif (isset($_POST['year'])) {
    $year = $_POST['year'];
    updateAlbumYear($albumId, $year);
    header("location: ../albums-edit-info.php?edit=year");
    exit();
} elseif (isset($_POST['albumname'])) {
    $name = $_POST['albumname'];
    updateAlbumName($albumId, $name);
    header("location: ../albums-edit-info.php?edit=year");
    exit();
}
