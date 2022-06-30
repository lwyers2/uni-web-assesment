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





// check if confirm has been passed as post

if (isset($_POST['confirm'])) {

    require_once 'dbconn.php';
    //check if value contains a value and check which value as posted
    if (isset($_POST['name']) && (!empty($_POST['name']))) {
        $name = $_POST['name'];
        editUsersName($name, $userId);
        header("location: ../update-info.php?success=name");
        exit();
    } elseif (isset($_POST['username']) && (!empty($_POST['username']))) {
        $username = $_POST['username'];
        if ((!checkUidExists($conn, $username)) && (!checkInvalidUid($username))) {
            editUsersUid($username, $userId);
            header("location: ../update-info.php?success=username");
            exit();
        } else {
            //confirms update unsuccessful
            header("location: ../update-info.php?error=invalidusername");
            exit();
        }
    } elseif (isset($_POST['email']) && (!empty($_POST['email']))) {
        $email = $_POST['email'];
        if ((!checkInvalidEmail($email)) && (!checkEmailExists($conn, $email))) {
            editUsersEmail($email, $userId);
            //confirms update successful
            header("location: ../update-info.php?success=email");
            exit();
        } else {
            //need to make error message
            header("location: ../update-info.php?error=invalidemail");
            exit();
        }
    } elseif (isset($_POST['pwd']) && isset($_POST['pwd-conf']) && (!empty($_POST['pwd'])) && (!empty($_POST['pwd-conf']))) {
        $pwd = $_POST['pwd'];
        $pwdConf = $_POST['pwd-conf'];
        if (checkPwdMatch($pwd, $pwdConf)) {
            editUsersPassword($pwd, $userId);
            //confirms update successful
            header("location: ../update-info.php?success=pwd");
            exit();
        } else {
            //need to make error message
            header("location: ../update-info.php?error=invalidpwd");
            exit();
        }
    }
}
