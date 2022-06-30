<?php
session_start();



var_dump($_POST);

//check if user has accessed the page using post
if (isset($_POST['favourite']) && isset($_POST['own'])) {

    var_dump($_POST);


    include("dbconn.php");
    include("functions.php");


    if (isset($_SESSION["useruid"])) {

        $userId = $_SESSION['userid'];
        $favourite = $_POST['favourite'];
        $own = $_POST['own'];
        $albumId = $_POST['albumId'];

        // If Owned already registered then update instead of add
        if (isUserOwnedSet($userId, $albumId)) {
            updateUserOwnedDB($albumId, $userId, $own);
        } else {
            addUserOwnedDB($albumId, $userId, $own);
        }

        // If Favourite already registered then update instead of add
        if (isUserFavouriteSet($userId, $albumId)) {
            updateUserFavouriteDB($albumId, $userId, $favourite);
        } else {
            addUserFavouritedDB($albumId, $userId, $favourite);
        }

        echo isUserOwnedSet($userId, $albumId);
        isUserFavouriteSet($userId, $albumId);
        //return user to album page after update made
        header("location: ../index.php?albumId=" . $albumId);
        exit();
    }
} else {
    //returns if user has typed in page into url
    header("location: ../../main/index.php");
    exit();
}
