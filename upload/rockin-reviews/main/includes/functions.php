<?php

function getTopRated()
{


    include("dbconn.php");
    $read = "SELECT * FROM albumInfo INNER JOIN artistInfo ON albumInfo.artistId= artistInfo.artistInfoId WHERE ranking='1';";
    $result = $conn->query($read);


    if (!$result) {
        echo $conn->error;
        exit();
    }




    while ($row = $result->fetch_assoc()) {
        $albumName = $row['albumName'];
        $albumYear = $row['albumYear'];
        $albumCover = $row['albumImgUrl'];
        $artistName = $row['artistName'];
        $albumId = $row['albumId'];


        echo "<div class='number1img'>
        <a href='../show-album/index.php?albumId={$albumId}'> <img src='$albumCover' width='250px' height='250px' alt='Album artwork for $albumName'></a>
         </div>
         <div class='number1info'>
             <h4>{$artistName}</h4>
             <h5>{$albumName}</h5>
         </div>
         <div class='number1desc'>
             <p>The Rolling Stones magazine declares this as the gretest album of all time.
             <br> 
             This website holds the top 500 albums from that same ranking list.
             <br> 
             You can create a profile to view, like and review all albums from that list. 
             <br>
             You can also add which ones you own. 
             <br>
             All of this is stored in your profile page which you can access at any time while logged in from the nav bar!</p>
         </div>";
    }
}

function getHighestScore()
{

    include("dbconn.php");

    // get all information from album info using album ID - GET from album link elsewhere
    $sql = "SELECT AVG(score), userScore.albumId, albumName, albumImgUrl  FROM albumInfo INNER JOIN userScore ON albumInfo.albumId= userScore.albumId GROUP BY albumInfo.albumId ORDER BY `AVG(score)` DESC";

    //initialise new statement

    $stmt = mysqli_stmt_init($conn);

    //if to return to main page if album id doesnt exist
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }




    //execute
    mysqli_stmt_execute($stmt);

    //stores the result of the statement
    $resultData = mysqli_stmt_get_result($stmt);

    // only display if info
    if ($row = mysqli_fetch_assoc($resultData)) {


        //get information for populating album page details

        $albumName = $row['albumName'];

        $albumCover = $row['albumImgUrl'];



        $albumId = $row['albumId'];
        $avgScore = round($row['AVG(score)'], 1);



        echo "<div class='best-x'>
        <div class='thumb'><a href='../show-album/index.php?albumId={$albumId}'><img src='$albumCover' width='100px' height='100px' alt='Album artwork for $albumName'></a></div>
        <div class='thumbdesc' id='bought-album'>Highest Scored Album :- <strong>{$avgScore}/5</strong> </div></div>";
    }

    mysqli_stmt_close($stmt);
}

function getMostFavourites()
{

    include("dbconn.php");

    // Returns the of ll iss favourites for an album
    $sql = "SELECT SUM(isFavourite), userFavourite.albumId, albumName, albumImgUrl, ranking FROM albumInfo INNER JOIN userFavourite ON albumInfo.albumId= userFavourite.albumId GROUP BY albumInfo.albumId ORDER BY `SUM(isFavourite)` DESC";

    //initialise new statement

    $stmt = mysqli_stmt_init($conn);

    //if to return to main page if album id doesnt exist
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }



    //execute
    mysqli_stmt_execute($stmt);

    //stores the result of the statement
    $resultData = mysqli_stmt_get_result($stmt);

    // only display if info
    if ($row = mysqli_fetch_assoc($resultData)) {


        //get information for populating album page details

        $albumName = $row['albumName'];

        $albumCover = $row['albumImgUrl'];



        $usersFavourite = $row['SUM(isFavourite)'];

        $albumId = $row['albumId'];

        echo "<div class='best-x'>
        <div class='thumb'><a href='../show-album/index.php?albumId={$albumId}'><img src='$albumCover' width='100px' height='100px' alt='Album artwork for $albumName'></a></div>
        <div class='thumbdesc' id='bought-album'>User's Favourite Album :- <strong>{$usersFavourite} Likes</strong></div></div>
       ";
    }

    mysqli_stmt_close($stmt);
}


function getMostOwned()
{
    include("dbconn.php");

    // Returns the of ll iss favourites for an album
    $sql = "SELECT SUM(isOwned), userOwned.albumId, albumName, albumImgUrl  FROM albumInfo INNER JOIN userOwned ON albumInfo.albumId= userOwned.albumId GROUP BY albumInfo.albumId ORDER BY `SUM(isOwned)` DESC";

    //initialise new statement

    $stmt = mysqli_stmt_init($conn);

    //if to return to main page if album id doesnt exist
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }



    //execute
    mysqli_stmt_execute($stmt);

    //stores the result of the statement
    $resultData = mysqli_stmt_get_result($stmt);

    // only display if info
    if ($row = mysqli_fetch_assoc($resultData)) {


        //get information for populating album page details

        $albumName = $row['albumName'];

        $albumCover = $row['albumImgUrl'];



        $usersOwned = $row['SUM(isOwned)'];

        $albumId = $row['albumId'];

        echo "<div class='best-x'>
        <div class='thumb'><a href='../show-album/index.php?albumId={$albumId}'><img src='$albumCover' width='100px' height='100px' alt='Album artwork for $albumName'></a></div>
        <div class='thumbdesc' id='bought-album'>Most Owned Album :-  <strong>{$usersOwned} Owned</strong></div></div>";
    }

    mysqli_stmt_close($stmt);
}



function getMostReviewed()
{
    include("dbconn.php");

    // Returns the of ll iss favourites for an album
    $sql = "SELECT SUM(isAccepted), review.albumId, albumName, albumImgUrl, ranking FROM albumInfo INNER JOIN review ON albumInfo.albumId= review.albumId GROUP BY albumInfo.albumId ORDER BY `SUM(isAccepted)` DESC;";

    //initialise new statement

    $stmt = mysqli_stmt_init($conn);

    //if to return to main page if album id doesnt exist
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }


    //execute
    mysqli_stmt_execute($stmt);

    //stores the result of the statement
    $resultData = mysqli_stmt_get_result($stmt);

    // only display if info
    if ($row = mysqli_fetch_assoc($resultData)) {


        //get information for populating album page details

        $albumName = $row['albumName'];

        $albumCover = $row['albumImgUrl'];

        $ranking = $row['ranking'];

        $usersReviewed = $row['SUM(isAccepted)'];

        $albumId = $row['albumId'];

        echo "<div class='best-x'>
        <div class='thumb'><a href='../show-album/index.php?albumId={$albumId}'><img src='$albumCover' width='100px' height='100px' alt='Album artwork for $albumName'></a></div>
        <div class='thumbdesc' id='bought-album'>Most Reviewed Album :- <strong>$usersReviewed Reviews</strong></div></div>";
    }

    mysqli_stmt_close($stmt);
}



function getTrending()
{

    include("dbconn.php");

    // Returns the of ll iss favourites for an album
    $sql = "SELECT * FROM albumInfo INNER JOIN review ON albumInfo.albumId= review.albumId ORDER BY `review`.`timeStamp` DESC";

    //initialise new statement

    $stmt = mysqli_stmt_init($conn);

    //if to return to main page if album id doesnt exist
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }



    //execute
    mysqli_stmt_execute($stmt);

    //stores the result of the statement
    $resultData = mysqli_stmt_get_result($stmt);

    $count = 1;
    // only display if info
    while ($row = mysqli_fetch_assoc($resultData)) {

        //only allow 8 trending albums - no more
        if ($count < 7) {

            //get information for populating album page details

            $albumName = $row['albumName'];

            $albumCover = $row['albumImgUrl'];
            $albumId = $row['albumId'];





            $albumId = $row['albumId'];

            echo "<div class='trending-album'><a href='../show-album/index.php?albumId={$albumId}'><img src='$albumCover' width='200px' height='200px' alt='Album artwork for $albumName'></a></div>";
            $count++;
        }
    }
}

function emptyInputSignup($name, $email, $username, $pwd, $pwdrepeat)
{

    $result = false;
    if (empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdrepeat)) {

        $result = true;
    } else {
        $result = false;
    }
    return $result;
}


function invalidUid($username)
{

    $result = false;
    if (!preg_match('/^[a-zA-Z0-9]*$/', $username)) {

        $result = true;
    } else {
        $result = false;
    }
    return $result;
}


function invalidEmail($email)
{

    $result = false;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}


function pwdMatch($pwd, $pwdrepeat)
{

    $result = false;
    if ($pwd !== $pwdrepeat) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function uidExists($conn, $username, $email)
{


    $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function createUser($conn, $name, $email, $username, $pwd)
{


    $sql = "INSERT INTO users (usersName, usersEmail, usersUid, usersPwd) VALUES (?,?,?,?);";

    //initialise new statement
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    //hashpasswords
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    //bind perameters
    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $hashedPwd);
    //execute
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    header("location: ../signup.php?success=s");
    exit();
}


function emptyInputLogin($username, $pwd)
{

    $result = false;
    if (empty($username) || empty($pwd)) {

        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function loginUser($conn, $username, $pwd)
{

    $uidExists = uidExists($conn, $username, $username);

    if ($uidExists === false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }

    $pwdHashed = $uidExists["usersPwd"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd == false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    } else if ($checkPwd === true) {
        session_start();
        //populate session with user id including type id to ensurre admin privledge
        $_SESSION["userid"] = $uidExists["usersId"];
        $_SESSION["useruid"] = $uidExists["usersUid"];
        $_SESSION["userTypeId"] = $uidExists["userTypeId"];
        header("location: ../index.php");
        exit();
    }
}
