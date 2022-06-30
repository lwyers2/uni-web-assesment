
<?php




function showUserInfo($userId)
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


function showUserInfoEdit($userId)
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

        echo '
       
        <table>
      
                <tr>
                    <th>Name:</th>
                    <th>' . $usersName . '</th>
                <tr>
                    <th>Username:</th>
                    <th>' . $usersUid . '</th>
                    </tr>
                    
                <tr>
                    <th>Email:</th>
                    <th>' . $usersEmail . '</th>
                    </tr>
                <tr>
                    <th>Password:</th>
                    <th>********</th>
                    </tr>
                
                
               

            </table>
           <a href="update-info.php"><button>Edit My Info</button></a>
            </form>
               
    ';
    }
    mysqli_stmt_close($stmt);
}


function hasFavourites($userId)
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


function showFavourites($userId)
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



    while ($row = $result->fetch_assoc()) {
        $albumName = $row['albumName'];
        $albumCover = $row['albumImgUrl'];
        $albumYear = $row['albumYear'];
        $albumId = $row['albumId'];


        echo "
    <div class='album'><a href='../show-album/index.php?albumId={$albumId}'><img src='$albumCover' width='250px' height='250px' alt='Album artwork for $albumName'></a><p>$albumName<br>$albumYear</p></div>";
    }
    mysqli_stmt_close($stmt);
}

function deleteFavourites($userId)
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



function hasOwned($userId)
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


function showOwned($userId)
{

    include("dbconn.php");

    $sql = "SELECT * FROM albumInfo INNER JOIN userOwned ON albumInfo.albumId=userOwned.albumId INNER JOIN users ON userOwned.userId=users.usersId WHERE users.usersId=? AND isOwned=1;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);



    while ($row = $result->fetch_assoc()) {
        $albumName = $row['albumName'];
        $albumCover = $row['albumImgUrl'];
        $albumYear = $row['albumYear'];
        $albumId = $row['albumId'];


        echo "
    <div class='album'><a href='../show-album/index.php?albumId={$albumId}'><img src='$albumCover' width='250px' height='250px' alt='Album artwork for $albumName'></a><p>$albumName<br>$albumYear</p></div>";
    }

    mysqli_stmt_close($stmt);
}


function hasUserReview($userId, $isAccepted)
{

    include("dbconn.php");




    //Select to find if a user has already left a review.
    $sql = "SELECT * FROM review  WHERE userId=? AND isAccepted=?";

    //initialise new statement

    $stmt = mysqli_stmt_init($conn);

    //if to return to main page if album id doesnt exist
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }



    //bind perameters
    mysqli_stmt_bind_param($stmt, "ii", $userId, $isAccepted);
    //execute
    mysqli_stmt_execute($stmt);

    //stores the result of the statement
    $resultData = mysqli_stmt_get_result($stmt);


    if (mysqli_fetch_assoc($resultData)) {
        //returns true if theres already a record
        return true;
    } else {
        return false;
    }


    mysqli_stmt_close($stmt);
}


function showReviews($userId, $isAccepted)
{


    if (hasUserReview($userId, $isAccepted) == true) {

        include("dbconn.php");

        //Get individual review
        $sql = "SELECT * FROM review INNER JOIN users ON review.userId=users.usersId WHERE review.userId=? AND review.isAccepted=$isAccepted";

        //initialise new statement

        $stmt = mysqli_stmt_init($conn);

        //if to return to main page if album id doesnt exist
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../main/index.php?error=stmtfailed");
            exit();
        }



        //bind perameters
        mysqli_stmt_bind_param($stmt, "i", $userId);
        //execute
        mysqli_stmt_execute($stmt);

        //stores the result of the statement
        $resultData = mysqli_stmt_get_result($stmt);

        // only display if info available
        while ($row = mysqli_fetch_assoc($resultData)) {

            $title = $row['reviewTitle'];
            $body = $row['reviewBody'];
            $isAccepted = $row['isAccepted'];
            $username = $row['usersUid'];
            $timestamp = $row['timeStamp'];

            if ($isAccepted == 0) {

                echo '
          
        <article class="card" id="pending">
        <header>
        <h3>' . $title . '</h3>
        <p class="username-review">By User: ' . $username . '</p>
        <p>My Review</p>
        </header>
        <footer>
           
                       <p class="body">' . $body . '</p>
                       <p class="timestamp">Posted On: ' . $timestamp . '</p>


        </footer>
    </article>';
            } else {
                echo '
            
        <article class="card" id="accepted">
        
        <header>
            <h3>' . $title . '</h3>
            <p class="username-review">By User: ' . $username . '</p>
            <p>My Review</p>

        </header>
        <footer>
        
        
            <p class="body">' . $body . '</p>
            <p class="timestamp">Posted On: ' . $timestamp . '</p>


        </footer>
    </article>
    ';
            }
        }



        mysqli_stmt_close($stmt);
    } else {
        echo 'No Reviews to show!!';
    }
}





function deleteOwned($userId)
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

function editUsersName($usersName, $userId)
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

function editUsersUid($usersUid, $userId)
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

function editUsersEmail($usersEmail, $userId)
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

function editUsersPassword($usersPwd, $userId)
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

function checkInvalidUid($username)
{

    $result = false;
    if (!preg_match('/^[a-zA-Z0-9]*$/', $username)) {

        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function checkInvalidEmail($email)
{

    $result = false;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function checkPwdMatch($pwd, $pwdrepeat)
{


    if ($pwd == $pwdrepeat) {
        return true;
    } else {
        return false;
    }
}


function checkUidExists($conn, $username)
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

function checkEmailExists($conn, $email)
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

function deleteUser($userId)
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
