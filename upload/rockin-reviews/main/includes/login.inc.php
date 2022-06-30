<?php
//check user accessed page correctly
if (isset($_POST['submit'])) {
    //named username, but could also be email
    $username = $_POST['uid'];
    $pwd = $_POST['pwd'];


    require_once 'dbconn.php';
    require_once 'functions.php';

    if (emptyInputLogin($username, $pwd) !== false) {
        header("location: ../login.php?error=emptyinput");
        exit();
    }
    loginUser($conn, $username, $pwd);
} else {
    header("location: ..login.php");
    exit();
}
