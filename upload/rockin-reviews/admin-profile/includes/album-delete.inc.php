<?php


session_start();

include("functions.php");


//only allows signed in ADMIN users entry
if ((!isset($_SESSION['userid'])) && (!$_SESSION['userTypeId'] == 0) && isset($_GET['albumId'])) { #
    header("location: ../main/index.php");
    exit();
}

$albumId = $_GET['albumId'];


deleteAllGenreFromAlbum($albumId);
deleteAllSubGenreFromAlbum($albumId);
deleteAlbum($albumId);
header("location: ../index.php?albumdelete=1");
exit();
