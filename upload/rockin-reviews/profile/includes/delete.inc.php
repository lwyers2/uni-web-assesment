<?php
session_start();
include("functions.php");


var_dump($_POST);

//only allows signed in users entry
if (!isset($_SESSION['userid'])) { #
    header("location: ../main/index.php");
    exit();
}



$userId = $_SESSION['userid'];

echo $userId;

if (hasOwned($userId)) {

    deleteOwned($userId);
}

if (hasFavourites($userId)) {

    deleteFavourites($userId);
}

if (hasReviews($userId)) {

    deleteAllReviews($userId);
}

if (hasUserScores($userId)) {

    deleteAllScores($userId);
}


deleteUser($userId);

header("location: ../../main/includes/logout.inc.php");
exit();
