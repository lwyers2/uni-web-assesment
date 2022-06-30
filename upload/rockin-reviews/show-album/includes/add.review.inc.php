<?php
session_start();
//check if user has accessed the page using post
include("dbconn.php");
require("functions.php");

//check if user is first signed in if not return to min page
if ((!isset($_SESSION['userid']))) {
    header("location: ../../main/index.php");
    exit();
}


// if post not sent will sent back to main page
if (isset($_POST['title'])) {

    include("dbconn.php");




    if (isset($_SESSION["useruid"])) {

        $userId = $_SESSION['userid'];
        $albumId = $_POST['albumId'];
        $body = $_POST['body'];
        $title = $_POST['title'];




        addUserReviews($albumId, $userId, $title, $body);

        //return user to album page after update made
        header("location: ../index.php?albumId=" . $albumId);
        exit();
    } else {
        //returns if user has typed in page into url
        header("location: ../../main/index.php");
        exit();
    }
}
