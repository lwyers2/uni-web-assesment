<?php


session_start();



//only allows signed in ADMIN users entry
if ((!isset($_SESSION['userid'])) && (!$_SESSION['userTypeId'] == 0)) { #
    header("location: ../main/index.php");
    exit();
}

if ((isset($_POST['albumid'])) && isset($_POST['userid'])) {

    include("functions.php");
    $albumId = $_POST['albumid'];
    $userId = $_POST['userid'];


    if (isset($_POST['approve'])) {
        approveReview($albumId, $userId);
        header("location: ../index.php?review=approved");
        exit();
    } elseif (isset($_POST['decline'])) {
        deleteReview($userId, $albumId);
        header("location: ../index.php?review=deleted");
        exit();
    } else {
        // header("location: ../index.php?review=error");
        // exit();
    }
} else {
    var_dump($_POST);
    echo "error";
}
