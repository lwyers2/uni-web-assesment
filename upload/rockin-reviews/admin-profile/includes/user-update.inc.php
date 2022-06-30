<?php
session_start();
include("functions.php");


var_dump($_POST);

//only allows signed in ADMIN users entry
if ((!isset($_SESSION['userid'])) && (!$_SESSION['userTypeId'] == 0)) {
    header("location: ../../main/index.php");
    exit();
}



if (!isset($_POST['userid'])) {
    header("location: ../../main/index.php");
} else {
    $userId = $_POST['userid'];
}






// check if confirm has been passed as post

if (isset($_POST['confirm'])) {

    require_once 'dbconn.php';
    //check if value contains a value and check which value as posted
    if (isset($_POST['name']) && (!empty($_POST['name']))) {
        $name = $_POST['name'];
        editUserAccountName($name, $userId);

        header("location: ../users-admin.php?success=name");
        exit();
    } elseif (isset($_POST['username']) && (!empty($_POST['username']))) {
        $username = $_POST['username'];
        if ((!checkAccountUidExists($conn, $username)) && (!checkInvalidAccountUid($username))) {
            editUserAccountUserName($username, $userId);
            header("location: ../users-admin.php?success=username");
            exit();
        } else {
            //confirms update unsuccessful
            header("location: ../users-admin?error=invalidusername");
            exit();
        }
    } elseif (isset($_POST['email']) && (!empty($_POST['email']))) {
        $email = $_POST['email'];
        if ((!checkInvalidAccountEmail($email)) && (!checkAccountEmailExists($conn, $email))) {
            editUserAccountEmail($email, $userId);
            //confirms update successful
            header("location: ../users-admin.php?success=email");
            exit();
        } else {
            //need to make error message
            header("location: ../users-admin.php?error=invalidemail");
            exit();
        }
    } elseif (isset($_POST['pwd']) && isset($_POST['pwd-conf'])) {
        $pwd = $_POST['pwd'];
        $pwdConf = $_POST['pwd-conf'];
        if (checkAccountPwdMatch($pwd, $pwdConf)) {
            editUserAccountPassword($pwd, $userId);
            //confirms update successful
            header("location: ../users-admin.php?success=pwd");
            exit();
        } else {
            //need to make error message
            header("location: ../users-admin.php?error=invalidpwd");
            exit();
        }
    }
}


//delete

if (isset($_POST['delete'])) {
    var_dump($_POST);
    require_once 'dbconn.php';

    if (hasOwnedAlbums($userId)) {

        deleteOwnedAlbums($userId);
    }

    if (hasFavouritesAlbums($userId)) {

        deleteFavouritesAlbums($userId);
    }

    if (hasReviews($userId)) {

        deleteAllReviews($userId);
    }

    if (hasUserScores($userId)) {

        deleteAllScores($userId);
    }


    deleteUserAccount($userId);


    header("location: ../users-admin.php?success=deleted");
    exit();
}
