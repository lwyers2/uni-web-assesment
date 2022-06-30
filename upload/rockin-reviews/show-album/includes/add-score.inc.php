<?php
session_start();
//check if user has accessed the page using post
if (isset($_POST['score'])) {

    include("dbconn.php");
    include("functions.php");



    if (isset($_SESSION["useruid"])) {

        $userId = $_SESSION['userid'];
        $score = $_POST['score'];
        $albumId = $_POST['albumId'];

        addUserRating($userId, $score, $albumId);
        //return user to album page after update made
        header("location: ../index.php?albumId=" . $albumId);
        exit();
    }
} else {
    //returns if user has typed in page into url
    header("location: ../../main/index.php");
    exit();
}
