<?php

function showAdminUserInfo($userId)
{


    include("dbconn.php");

    $sql = "SELECT * FROM users WHERE usersId = ?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);



    while ($row = mysqli_fetch_assoc($resultData)) {

        $usersUid = $row['usersUid'];
        $usersName = $row['usersName'];
        $usersEmail = $row['usersEmail'];


        echo " 
    <div class='show-info'>
        <h1>{$usersUid}</h1>
        <h2>{$usersName}</h2>
        <h3>{$usersEmail}</h3>
    </div>";
    }

    mysqli_stmt_close($stmt);
}

function showReviews()
{
    include("dbconn.php");

    //Get all reviews except those already approved. It also returns album info to populate album name for review
    $sql = "SELECT * FROM review INNER JOIN users ON review.userId=users.usersId INNER JOIN albumInfo ON review.albumId=albumInfo.albumId WHERE review.isAccepted=0;";

    //initialise new statement

    $stmt = mysqli_stmt_init($conn);

    //if to return to main page if album id doesnt exist
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }




    mysqli_stmt_execute($stmt);

    //stores the result of the statement
    $resultData = mysqli_stmt_get_result($stmt);


    //Check if none to print out message

    if (mysqli_fetch_assoc($resultData)) {

        //Displays all reviews
        while ($row = mysqli_fetch_assoc($resultData)) {

            $title = $row['reviewTitle'];
            $body = $row['reviewBody'];
            $username = $row['usersUid'];
            $albumName = $row['albumName'];
            $userId = $row['userId'];
            $albumId = $row['albumId'];


            echo '
            
        <article class="card">
        <header>
        <h3>' . $title . '</h3>
        <p class="username-review">By User: ' . $username . '</p>
        <p>Album Name: ' . $albumName . '</p>
   
        </header>
        <footer>
           
                       <p class="body">' . $body . '</p>
                      
                       <form action ="includes/review-update.inc.php" method="post">
                       <input type="hidden" name="userid" value=' . $userId . '>
                       <input type="hidden" name="albumid" value=' . $albumId . '>
                       <input class="success" type="submit" name="approve" value="Approve">
                       <input class="error" type="submit" name="decline" value="Decline/Delete">

                       </form>


        </footer>
    </article>';
        }
    } else {
        echo "<p>No more pending reviews!!</p>";
    }
    mysqli_stmt_close($stmt);
}

function approveReview($albumId, $userId)
{

    include("dbconn.php");

    $sql = "UPDATE `review` SET `isAccepted` = '1' WHERE `review`.`userId` = ? AND `review`.`albumId` = ?;
    ";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }

    if (mysqli_stmt_bind_param($stmt, "ii", $userId, $albumId))

        mysqli_stmt_execute($stmt);



    mysqli_stmt_close($stmt);
}

//named delete as if it were decline wouldn't make as much sense
function deleteReview($userId, $albumId)
{

    include("dbconn.php");

    $sql = "DELETE FROM `review` WHERE `review`.`userId` = ? AND `review`.`albumId` = ?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ii", $userId, $albumId);
    mysqli_stmt_execute($stmt);



    mysqli_stmt_close($stmt);
}

function deleteAllReviews($userId)
{
    include("dbconn.php");

    $sql = "DELETE FROM `review` WHERE `review`.`userId` = ?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $userId,);
    mysqli_stmt_execute($stmt);



    mysqli_stmt_close($stmt);
}

function hasReviews($userId)
{
    include("dbconn.php");

    $sql = "SELECT * FROM `review` WHERE `review`.`userId` = ?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($result->fetch_assoc() == null) {
        return false;
    } else {
        return true;
    }

    mysqli_stmt_close($stmt);
}

function showAllUsers()
{
    include("dbconn.php");

    //Get all reviews except those already approved. It also returns album info to populate album name for review
    $sql = "SELECT * FROM users";

    //initialise new statement

    $stmt = mysqli_stmt_init($conn);

    //if to return to main page if album id doesnt exist
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }




    mysqli_stmt_execute($stmt);

    //stores the result of the statement
    $resultData = mysqli_stmt_get_result($stmt);

    //create Headers
    echo '
    
    <table>
    <tr>
      <th>User ID</th>
      <th>User Name</th>
      <th>Users UserName</th>
      <th>Users Email</th>
      <th>Edit</th>
      <th>Delete</th> 
    </tr>';

    while ($row = mysqli_fetch_assoc($resultData)) {

        $userId = $row['usersId'];
        $usersName = $row['usersName'];
        $userUid = $row['usersUid'];
        $userEmail = $row['usersEmail'];
        $userTypeId = $row['userTypeId'];

        //check if admin user or not - cant delete admin users
        if ($userTypeId == 1) {

            echo '

    <tr>
  <th>' . $userId . '</th>
  <th>' . $usersName . '</th>
  <th>' . $userUid . '</th>
  <th>' . $userEmail . '</th>
  <th>
  <form action="user-update.php" method="post">
  <input type="hidden" name="userid" value="' . $userId . '">
  <input type="submit" name="edit" value="Edit" class="success">
  </form>
  
  </th>
  <th>
  <form action="includes/user-update.inc.php" method="post">
  <input type="hidden" name="userid" value="' . $userId . '">
  <input type="submit" name="delete" value="Delete" class="error">
  </form>
    </th>
  </tr>

  
    ';
        } else {
            echo '

        <tr>
      <th>' . $userId . '</th>
      <th>' . $usersName . '</th>
      <th>' . $userUid . '</th>
      <th>' . $userEmail . '</th>
      <th><s>Edit</s></th>
      <th><s>Delete</s></th>
      </tr>
      ';
        }
    }
    echo '</table>';
    mysqli_stmt_close($stmt);
}

function editUserAccountName($usersName, $userId)
{

    include("dbconn.php");

    //prepared statment 
    $sql = "UPDATE `users` SET `usersName` = ? WHERE `users`.`usersId` = ?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "si", $usersName, $userId);
    mysqli_stmt_execute($stmt);


    mysqli_stmt_close($stmt);
}

function editUserAccountUsername($usersUid, $userId)
{
    include("dbconn.php");

    //prepared statment 
    $sql = "UPDATE `users` SET `usersUid` = ? WHERE `users`.`usersId` = ?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "si", $usersUid, $userId);
    mysqli_stmt_execute($stmt);


    mysqli_stmt_close($stmt);
}


function editUserAccountEmail($usersEmail, $userId)
{


    include("dbconn.php");

    //prepared statment 
    $sql = "UPDATE `users` SET `usersEmail` = ? WHERE `users`.`usersId` = ?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "si", $usersEmail, $userId);
    mysqli_stmt_execute($stmt);


    mysqli_stmt_close($stmt);
}

function editUserAccountPassword($usersPwd, $userId)
{
    include("dbconn.php");

    //prepared statment 
    $sql = "UPDATE `users` SET `usersPwd` = ? WHERE `users`.`usersId` = ?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }

    //hashpasswords
    $hashedPwd = password_hash($usersPwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "si", $hashedPwd, $userId);
    mysqli_stmt_execute($stmt);


    mysqli_stmt_close($stmt);
}

function checkInvalidAccountUid($username)
{

    $result = false;
    if (!preg_match('/^[a-zA-Z0-9]*$/', $username)) {

        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function checkInvalidAccountEmail($email)
{

    $result = false;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function checkAccountPwdMatch($pwd, $pwdrepeat)
{


    if ($pwd == $pwdrepeat) {
        return true;
    } else {
        return false;
    }
}


function checkAccountUidExists($conn, $username)
{


    $sql = "SELECT * FROM users WHERE usersUid = ?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $username);
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

function checkAccountEmailExists($conn, $email)
{


    $sql = "SELECT * FROM users WHERE usersEmail = ?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
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

function deleteUserAccount($userId)
{
    include("dbconn.php");

    $sql = "DELETE FROM `users` WHERE `usersId` = ?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "Delete User didnt work";
        //header("location: ../main/index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function hasOwnedAlbums($userId)
{

    include("dbconn.php");

    $sql = "SELECT * FROM albumInfo INNER JOIN userOwned ON albumInfo.albumId=userOwned.albumId INNER JOIN users ON userOwned.userId=users.usersId WHERE users.usersId=?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);



    if ($result->fetch_assoc() == null) {
        return false;
    } else {
        return true;
    }



    mysqli_stmt_close($stmt);
}


function hasFavouritesAlbums($userId)
{
    include("dbconn.php");

    $sql = "SELECT * FROM albumInfo INNER JOIN userFavourite ON albumInfo.albumId=userFavourite.albumId INNER JOIN users ON userFavourite.userId=users.usersId WHERE users.usersId=? AND isFavourite=1;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($result->fetch_assoc() == null) {
        return false;
    } else {
        return true;
    }
}

function deleteOwnedAlbums($userId)
{
    include("dbconn.php");

    $sql = "DELETE FROM `userOwned` WHERE `userId` = ?;";

    $stmt = mysqli_stmt_init($conn);

    echo "Hello";

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "Owned Delete didnt work";
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function deleteFavouritesAlbums($userId)
{

    include("dbconn.php");

    $sql = "DELETE FROM `userFavourite` WHERE `userId` = ?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {

        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function showSearchedAlbumArtistEdit($searchAlbum)
{

    $endpoint = "http://lwyers01.webhosting6.eeecs.qub.ac.uk/rockin-reviews/api/api.php?q={$searchAlbum}&type=ar";

    $resource = file_get_contents($endpoint);

    $data = json_decode($resource, true);


    foreach ($data as $row) {


        //get information for populating album page details

        $albumName = $row['albumName'];
        $albumCover = $row['albumImgUrl'];
        $artistName = $row['artistName'];
        $albumId = $row['albumId'];


        echo "
    <div class='album'><a href='update-album.php?albumId={$albumId}'><img src='$albumCover' width='250px' height='250px' alt='Album artwork for $albumName'></a><p>$artistName<br>$albumName</p></div>";
    }
}

function showSearchedAlbumAlbumEdit($searchAlbum)
{

    $endpoint = "http://lwyers01.webhosting6.eeecs.qub.ac.uk/rockin-reviews/api/api.php?q={$searchAlbum}&type=al";

    $resource = file_get_contents($endpoint);

    $data = json_decode($resource, true);


    foreach ($data as $row) {


        //get information for populating album page details

        $albumName = $row['albumName'];
        $albumCover = $row['albumImgUrl'];
        $albumYear = $row['albumYear'];
        $albumId = $row['albumId'];

        echo "
        <div class='album'><a href='update-album.php?albumId={$albumId}'><img src='$albumCover' width='250px' height='250px' alt='Album artwork for $albumName'></a><p>$albumName<br>$albumYear</p></div>";
    }
}

function showSearchedAlbumGenreEdit($searchGenre)
{

    $endpoint = "http://lwyers01.webhosting6.eeecs.qub.ac.uk/rockin-reviews/api/api.php?q={$searchGenre}&type=g";

    $resource = file_get_contents($endpoint);

    $data = json_decode($resource, true);


    foreach ($data as $row) {


        //get information for populating album page details
        $albumName = $row['albumName'];
        $albumCover = $row['albumImgUrl'];
        $genreName = $row['genreName'];
        $albumId = $row['albumId'];

        echo "<div class='album'><a href='update-album.php?albumId={$albumId}'><img src='$albumCover' width='250px' height='250px' alt='Album artwork for $albumName'></a><p>$albumName<br>$genreName</p></div>";
    }
}

function showSearchedAlbumSubGenreEdit($searchSubGenre)
{

    if ($_GET) {



        $endpoint = "http://lwyers01.webhosting6.eeecs.qub.ac.uk/rockin-reviews/api/api.php?q={$searchSubGenre}&type=s";

        $resource = file_get_contents($endpoint);

        $data = json_decode($resource, true);


        foreach ($data as $row) {


            //get information for populating album page details
            $albumName = $row['albumName'];
            $albumCover = $row['albumImgUrl'];
            $genreName = $row['genreName'];
            $albumId = $row['albumId'];

            echo "<div class='album'><a href='update-album.php?albumId={$albumId}'><img src='$albumCover' width='250px' height='250px' alt='Album artwork for $albumName'></a><p>$albumName<br>$genreName</p></div>";
        }
    }
}

function showSearchedAlbumYearEdit($searchYear)
{

    $endpoint = "http://lwyers01.webhosting6.eeecs.qub.ac.uk/rockin-reviews/api/api.php?q={$searchYear}&type=y";

    $resource = file_get_contents($endpoint);

    $data = json_decode($resource, true);


    foreach ($data as $row) {


        //get information for populating album page details
        $albumName = $row['albumName'];
        $albumCover = $row['albumImgUrl'];
        $albumYear = $row['albumYear'];
        $albumId = $row['albumId'];


        echo "
      <div class='album'><a href='update-album.php?albumId={$albumId}'><img src='$albumCover' width='250px' height='250px' alt='Album artwork for $albumName'></a><p>$albumName<br>$albumYear</p></div>";
    }
}

function getAlbumName($albumId)
{


    include("dbconn.php");

    // get all information from album info using album ID - GET from album link elsewhere
    $sql = "SELECT * FROM albumInfo  WHERE albumId =?;";

    //initialise new statement

    $stmt = mysqli_stmt_init($conn);

    //if to return to main page if album id doesnt exist
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }



    //bind perameters
    mysqli_stmt_bind_param($stmt, "i", $albumId);
    //execute
    mysqli_stmt_execute($stmt);

    //stores the result of the statement
    $resultData = mysqli_stmt_get_result($stmt);

    // only display if info
    if ($row = mysqli_fetch_assoc($resultData)) {


        //get information for populating album page details

        $albumName = $row['albumName'];

        return $albumName;
    }

    mysqli_stmt_close($stmt);
}

function updateRank($albumId, $ranking)
{
    include("dbconn.php");

    $sql = "UPDATE `albumInfo` SET `ranking` = ? WHERE `albumInfo`.`albumId` = ?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }


    mysqli_stmt_bind_param($stmt, "ii",  $ranking, $albumId);
    mysqli_stmt_execute($stmt);



    mysqli_stmt_close($stmt);
}

function updateCover($albumId, $coverUrl)
{
    include("dbconn.php");

    $sql = "UPDATE `albumInfo` SET `albumImgUrl` = ? WHERE `albumInfo`.`albumId` = ?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }


    mysqli_stmt_bind_param($stmt, "si",  $coverUrl, $albumId);
    mysqli_stmt_execute($stmt);



    mysqli_stmt_close($stmt);
}

function updateArtist($albumId, $artistId)
{
    include("dbconn.php");

    $sql = "UPDATE `albumInfo` SET `artistId` = ? WHERE `albumInfo`.`albumId` = ?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }


    mysqli_stmt_bind_param($stmt, "ii", $artistId, $albumId);
    mysqli_stmt_execute($stmt);



    mysqli_stmt_close($stmt);
}

function getArtistId($artistName)
{

    include("dbconn.php");

    $sql = "SELECT * FROM artistInfo WHERE artistName = ?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }
    echo "helo";

    mysqli_stmt_bind_param($stmt, "s", $artistName);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row['artistInfoId'];
    }



    mysqli_stmt_close($stmt);
}

function isRegisteredArtist($artistName)
{
    include("dbconn.php");

    $sql = "SELECT * FROM artistInfo WHERE artistName = ?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }
    echo "helo";

    mysqli_stmt_bind_param($stmt, "s", $artistName);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if (mysqli_fetch_assoc($resultData)) {
        return true;
    } else {
        return false;
    }



    mysqli_stmt_close($stmt);
}

function registerArtist($artistName)
{
    include("dbconn.php");

    $sql = "INSERT INTO `artistInfo` (`artistInfoId`, `artistName`) VALUES (NULL, ?);";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }


    mysqli_stmt_bind_param($stmt, "s", $artistName);
    mysqli_stmt_execute($stmt);



    mysqli_stmt_close($stmt);
}


function updateAlbumYear($albumId, $year)
{
    include("dbconn.php");

    $sql = "UPDATE `albumInfo` SET `albumYear` = ? WHERE `albumInfo`.`albumId` = ?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }
    echo "helo";

    mysqli_stmt_bind_param($stmt, "ii", $year, $albumId);
    mysqli_stmt_execute($stmt);



    mysqli_stmt_close($stmt);
}



function updateAlbumName($albumId, $name)
{
    include("dbconn.php");

    $sql = "UPDATE `albumInfo` SET `albumName` = ? WHERE `albumInfo`.`albumId` = ?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }
    echo "helo";

    mysqli_stmt_bind_param($stmt, "si", $name, $albumId);
    mysqli_stmt_execute($stmt);



    mysqli_stmt_close($stmt);
}


function showAllGenres($albumId)
{

    include("dbconn.php");

    $sql = "SELECT * FROM `genre` INNER JOIN albumGenre ON genre.genreId=albumGenre.genreId INNER JOIN albumInfo ON albumGenre.albumId=albumInfo.albumId WHERE albumGenre.albumId=?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $albumId);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);



    while ($row = mysqli_fetch_assoc($resultData)) {

        $genreName = $row['genreName'];



        echo ' 
        
        <tr>
        <th>' . $genreName . '</th>
        <form action="includes/delete-genre.inc.php" method="post">
            <input type="hidden" name="genre" value="' . $genreName . '">
            <input type="hidden" name="albumid" value="' . $albumId . '">
            <input type="hidden" name="sub" value="0">
            <th><input type="submit" class="error" name="delete" value="Delete"></th>

        </form>
    </tr>
    ';
    }

    echo '<tr class="add-genre" style="display:none">
    <form action="includes/add-genre.inc.php" method="post">
        <th><input type="text" name="genre" placeholder="Add New genre"></th>
        <input type="hidden" name="albumid" value="' . $albumId . '">
        <input type="hidden" name="sub" value="0">
        <th><input type="submit" class="success" name="add" value="Add Genre"></th>
    </form>
    </tr>';

    mysqli_stmt_close($stmt);
}

function showAllSubGenres($albumId)
{
    include("dbconn.php");

    $sql = "SELECT * FROM `genre` INNER JOIN albumSubGenre ON genre.genreId=albumSubGenre.genreId INNER JOIN albumInfo ON albumSubGenre.albumId=albumInfo.albumId WHERE albumSubGenre.albumId=?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $albumId);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);



    while ($row = mysqli_fetch_assoc($resultData)) {

        $genreName = $row['genreName'];



        echo ' 
        
        <tr>
        <th>' . $genreName . '</th>
        <form action="includes/delete-genre.inc.php" method="post">
            <input type="hidden" name="genre" value="' . $genreName . '">
            <input type="hidden" name="albumid" value="' . $albumId . '">
            <input type="hidden" name="sub" value="1">
            <th><input type="submit" class="error" name="delete" value="Delete"></th>

        </form>
    </tr>
    ';
    }

    echo '<tr class="add-genre" style="display:none">
    <form action="includes/add-genre.inc.php" method="post">
        <th><input type="text" name="genre" placeholder="Add New genre"></th>
        <input type="hidden" name="albumid" value="' . $albumId . '">
        <input type="hidden" name="sub" value="1">

        
        <th><input type="submit" class="success" name="add" value="Add Genre"></th>
    </form>
    </tr>';

    mysqli_stmt_close($stmt);
}


function isGenreRegistered($genreName)
{

    include("dbconn.php");

    $sql = "SELECT * FROM `genre` WHERE genreName=?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $genreName);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if (mysqli_fetch_assoc($resultData)) {
        return true;
    } else {
        return false;
    }

    mysqli_stmt_close($stmt);
}

function getGenreId($genreName)
{
    include("dbconn.php");

    $sql = "SELECT * FROM `genre` WHERE genreName=?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $genreName);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);



    if ($row = mysqli_fetch_assoc($resultData)) {
        $genreId = $row['genreId'];
        return $genreId;
    }


    mysqli_stmt_close($stmt);
}

function deleteGenreFromAlbum($albumId, $genreId)
{
    include("dbconn.php");

    $sql = "DELETE FROM `albumGenre` WHERE albumId=? AND genreId =?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ii", $albumId, $genreId);
    mysqli_stmt_execute($stmt);



    mysqli_stmt_close($stmt);
}

function deleteSubGenreFromAlbum($albumId, $genreId)
{
    include("dbconn.php");

    $sql = "DELETE FROM `albumSubGenre` WHERE albumId=? AND genreId =?;;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ii", $albumId, $genreId);
    mysqli_stmt_execute($stmt);



    mysqli_stmt_close($stmt);
}

function registerGenre($genreName)
{
    include("dbconn.php");

    $sql = "INSERT INTO `genre` (`genreId`, `genreName`) VALUES (NULL, ?);";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $genreName);
    mysqli_stmt_execute($stmt);

    echo "I work" . $genreName;

    mysqli_stmt_close($stmt);
}

function addGenreToAlbum($genreId, $albumId)
{

    include("dbconn.php");

    $sql = "INSERT INTO `albumGenre` (`albumId`, `genreId`) VALUES (?, ?);";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ii", $albumId, $genreId);
    mysqli_stmt_execute($stmt);



    mysqli_stmt_close($stmt);
}

function addSubGenreToAlbum($genreId, $albumId)
{

    include("dbconn.php");

    $sql = "INSERT INTO `albumSubGenre` (`albumId`, `genreId`) VALUES (?, ?);";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ii", $albumId, $genreId);
    mysqli_stmt_execute($stmt);



    mysqli_stmt_close($stmt);
}



function deleteAllGenreFromAlbum($albumId)
{
    include("dbconn.php");

    $sql = "DELETE FROM `albumGenre` WHERE albumId=?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $albumId);
    mysqli_stmt_execute($stmt);



    mysqli_stmt_close($stmt);
}

function deleteAllSubGenreFromAlbum($albumId)
{
    include("dbconn.php");

    $sql = "DELETE FROM `albumSubGenre` WHERE albumId=?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $albumId);
    mysqli_stmt_execute($stmt);



    mysqli_stmt_close($stmt);
}


function deleteAlbum($albumId)
{
    include("dbconn.php");

    $sql = "DELETE FROM `albumInfo` WHERE `albumInfo`.`albumId` = ?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $albumId);
    mysqli_stmt_execute($stmt);



    mysqli_stmt_close($stmt);
}

function createAlbum($name, $rank, $artist, $year)
{




    if (isRegisteredArtist($artist)) {
        $artistId = getArtistId($artist);
    } else {
        registerArtist($artist);
        $artistId = getArtistId($artist);
    }





    include("dbconn.php");

    $sql = "INSERT INTO `albumInfo` (`albumId`, `albumName`, `albumImgUrl`,  `ranking`, `artistId`, `albumYear`) VALUES (NULL, ?, 'Placeholder',  ?, ?, ?);";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "siii", $name, $rank, $artistId, $year);
    mysqli_stmt_execute($stmt);



    mysqli_stmt_close($stmt);
}

function getAlbumId($albumName, $rank)
{
    include("dbconn.php");

    $sql = "SELECT * FROM `albumInfo` WHERE albumName=? AND ranking=?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "si", $albumName, $rank);
    mysqli_stmt_execute($stmt);



    $resultData = mysqli_stmt_get_result($stmt);



    if ($row = mysqli_fetch_assoc($resultData)) {
        $albumId = $row['albumId'];
        return $albumId;
    }


    mysqli_stmt_close($stmt);
}

function hasUserScores($userId)
{

    include("dbconn.php");

    $sql = "SELECT * FROM `userScore` WHERE `userId`=?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($result->fetch_assoc() == null) {
        return false;
    } else {
        return true;
    }
}

function deleteAllScores($userId)
{
    include("dbconn.php");

    $sql = "DELETE FROM `userScore` WHERE `userId` = ?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {

        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
