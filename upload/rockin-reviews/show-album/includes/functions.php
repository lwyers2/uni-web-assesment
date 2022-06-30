<?php



function getAlbumAPI($albumId)
{
    $endpoint = "http://lwyers01.webhosting6.eeecs.qub.ac.uk/rockin-reviews/api/api.php?showAlbum={$albumId}";

    $resource = file_get_contents($endpoint);

    $data = json_decode($resource, true);


    foreach ($data as $row) {


        //get information for populating album page details

        $albumName = $row['albumName'];
        $albumYear = $row['albumYear'];
        $albumCover = $row['albumImgUrl'];
        $artistName = $row['artistName'];
        $ranking = $row['ranking'];

        echo '<div class="album-details">
        <div class="album-info">
            <h1>' . $albumName . '</h1> 
            <h2>' . $artistName . '</h2>
            <h4>' . $albumYear . '</h4>
        </div>
    
        <div class="album-art">
        <h6>Rolling Stones Ranking: #' . $ranking . '</h6>
            <img src="' . $albumCover . '" width="300px" height="300px" alt="Album artwork ' . $albumName . '">
        </div>
    </div>';
    }
}

function showGenres($albumId)
{
    $endpoint = "http://lwyers01.webhosting6.eeecs.qub.ac.uk/rockin-reviews/api/api.php?showGenre={$albumId}";

    $resource = file_get_contents($endpoint);

    $data = json_decode($resource, true);

    echo '<div class="genres"> Genres: ';

    $count = 1;
    foreach ($data as $row) {
        $genreName = $row['genreName'];
        if ($count < count($data)) {

            echo $genreName . ", ";
            $count++;
        } else {
            echo $genreName;
        }
    }

    echo '</div>';
}

function showSubGenres($albumId)
{


    $endpoint = "http://lwyers01.webhosting6.eeecs.qub.ac.uk/rockin-reviews/api/api.php?showSubGenre={$albumId}";

    $resource = file_get_contents($endpoint);

    $data = json_decode($resource, true);

    echo '<div class="subgenres">Sub-Genres: ';

    $count = 1;
    foreach ($data as $row) {
        $genreName = $row['genreName'];
        if ($count < count($data)) {

            echo $genreName . ", ";
            $count++;
        } else {
            echo $genreName;
        }
    }

    echo '</div>';
}

function isUserRatingSet($userId, $albumId)
{

    include("dbconn.php");

    //Select to find a user's uniqe score Inner joining albuminfo on userScore and user information.
    $sql = "SELECT score FROM albumInfo INNER JOIN userScore ON albumInfo.albumId=userScore.albumId INNER JOIN users ON userScore.userId=users.usersId WHERE users.usersId=? AND albumInfo.albumId=?;";

    //initialise new statement

    $stmt = mysqli_stmt_init($conn);

    //if to return to main page if album id doesnt exist
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }



    //bind perameters
    mysqli_stmt_bind_param($stmt, "ii", $userId, $albumId);
    //execute
    mysqli_stmt_execute($stmt);

    //stores the result of the statement
    $resultData = mysqli_stmt_get_result($stmt);

    // only display if info
    if (mysqli_fetch_assoc($resultData)) {



        //get information for populating album page details

        return true;
    }


    mysqli_stmt_close($stmt);
}


function getUserRating($userId, $albumId)
{

    include("dbconn.php");

    //Select to find a user's uniqe score Inner joining albuminfo on userScore and user information.
    $sql = "SELECT score FROM albumInfo INNER JOIN userScore ON albumInfo.albumId=userScore.albumId INNER JOIN users ON userScore.userId=users.usersId WHERE users.usersId=? AND albumInfo.albumId=?;";

    //initialise new statement

    $stmt = mysqli_stmt_init($conn);

    //if to return to main page if album id doesnt exist
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }




    //bind perameters
    mysqli_stmt_bind_param($stmt, "ii", $userId, $albumId);
    //execute
    mysqli_stmt_execute($stmt);

    //stores the result of the statement
    $resultData = mysqli_stmt_get_result($stmt);

    // only display if info
    if ($row = mysqli_fetch_assoc($resultData)) {


        $userScore = $row['score'];
        //get information for populating album page details


        return $userScore;
    } else {
        //returning -1 if none for a check when adding rating
        return -1;
    }


    mysqli_stmt_close($stmt);
}


function addUserRating($userId, $score, $albumId)
{

    include("dbconn.php");

    //Select to find a user's uniqe score Inner joining albuminfo on userScore and user information.
    $sql = "INSERT INTO `userScore` (`albumId`, `userId`, `score`) VALUES (?, ?, ?)";

    //initialise new statement

    $stmt = mysqli_stmt_init($conn);

    //if to return to main page if album id doesnt exist
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }





    //bind perameters
    mysqli_stmt_bind_param($stmt, "iii", $albumId, $userId, $score);
    //execute
    mysqli_stmt_execute($stmt);





    mysqli_stmt_close($stmt);
}



function addUserScoreDivs($albumId)
{

    echo '<div class="add-score" >
        <form action="includes/add-score.inc.php" method="post">
        <input type="number" name="score" id="input_score" style="display:none">
        <input type="number" name="albumId" id="albumId" style="display:none" value="' . $albumId . '">
        <input type ="submit" class="pseudo button" style="border-bottom:solid 2px grey;" value ="Add Score">
        </form>
        </div>';
}


function getCommunityRating($albumId)
{


    $endpoint = "http://lwyers01.webhosting6.eeecs.qub.ac.uk/rockin-reviews/api/api.php?commRating={$albumId}";

    $resource = file_get_contents($endpoint);

    $data = json_decode($resource, true);


    if (empty($data)) {
        return -1;
    }

    // only display if info
    foreach ($data as $row) {


        $commScore = $row['score'];
        //get information for populating album page details


        return $commScore;
    }
}



function createFavouritedDiv($isFavourite, $isSet)
{

    // if its set it could be set as no i.e someone favourited then changed favourite. Checks if its already set then whether it is favourited or not
    if ($isSet) {

        if ($isFavourite) {
            echo ' <div class="favourite">Added to Favourites: <i class="fa-solid fa-heart" onclick=toggleFavourite(false)></i></div>';
        } else {
            echo ' <div class="favourite">Add to Favourites: <i class="fa-regular fa-heart" onclick=toggleFavourite(true)></i></div>';
        }
    } else {
        echo ' <div class="favourite">Add to Favourites: <i class="fa-regular fa-heart" onclick=toggleFavourite(true)></i></div>';
    }
}

function createOwneddDiv($isOwned, $isSet)
{


    if ($isSet) {
        if ($isOwned) {
            echo ' <div class="owned">Owned: <i class="fa-solid fa-dollar-sign" onclick=toggleOwned(false) style="color:green"></i></div>';
        } else {
            echo ' <div class="owned">Add to Owned: <i class="fa-regular fa-dollar-sign" onclick=toggleOwned(true) style="color:grey"></i>
            </div>';
        }
    } else {
        echo ' <div class="owned">Add to Owned: <i class="fa-regular fa-dollar-sign" onclick=toggleOwned(true) style="color:grey"></i>
        </div>';
    }
}

function isUserFavouriteSet($userId, $albumId)
{
    include("dbconn.php");

    //Similar to score - need to do an inner join on userFavourite due to relational database
    $sql = "SELECT isFavourite FROM albumInfo INNER JOIN userFavourite ON albumInfo.albumId=userFavourite.albumId INNER JOIN users ON userFavourite.userId=users.usersId WHERE users.usersId=? AND albumInfo.albumId=?;";

    //initialise new statement

    $stmt = mysqli_stmt_init($conn);

    //if to return to main page if album id doesnt exist
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }



    //bind perameters
    mysqli_stmt_bind_param($stmt, "ii", $userId, $albumId);
    //execute
    mysqli_stmt_execute($stmt);

    //stores the result of the statement
    $resultData = mysqli_stmt_get_result($stmt);

    // only display if info
    if (mysqli_fetch_assoc($resultData)) {




        return true;
    }


    mysqli_stmt_close($stmt);
}

function getUserFavourite($userId, $albumId)
{
    include("dbconn.php");

    //Similar to score - need to do an inner join on userFavourite due to relational database
    $sql = "SELECT isFavourite FROM albumInfo INNER JOIN userFavourite ON albumInfo.albumId=userFavourite.albumId INNER JOIN users ON userFavourite.userId=users.usersId WHERE users.usersId=? AND albumInfo.albumId=?;";

    //initialise new statement

    $stmt = mysqli_stmt_init($conn);

    //if to return to main page if album id doesnt exist
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }



    //bind perameters
    mysqli_stmt_bind_param($stmt, "ii", $userId, $albumId);
    //execute
    mysqli_stmt_execute($stmt);

    //stores the result of the statement
    $resultData = mysqli_stmt_get_result($stmt);

    // only display if info
    if ($row = mysqli_fetch_assoc($resultData)) {

        $isFavourite = $row['isFavourite'];
    }
    return $isFavourite;


    mysqli_stmt_close($stmt);
}


function isUserOwnedSet($userId, $albumId)
{
    include("dbconn.php");

    //Similar to score - need to do an inner join on userFavourite due to relational database
    $sql = "SELECT isOwned FROM albumInfo INNER JOIN userOwned ON albumInfo.albumId=userOwned.albumId INNER JOIN users ON userOwned.userId=users.usersId WHERE users.usersId=? AND albumInfo.albumId=?;";

    //initialise new statement

    $stmt = mysqli_stmt_init($conn);

    //if to return to main page if album id doesnt exist
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }



    //bind perameters
    mysqli_stmt_bind_param($stmt, "ii", $userId, $albumId);
    //execute
    mysqli_stmt_execute($stmt);

    //stores the result of the statement
    $resultData = mysqli_stmt_get_result($stmt);

    // only display if info
    if ($row = mysqli_fetch_assoc($resultData)) {



        //get information for populating album page details

        return true;
    }


    mysqli_stmt_close($stmt);
}

function getUserOwned($userId, $albumId)
{
    include("dbconn.php");

    //Similar to score - need to do an inner join on userFavourite due to relational database
    $sql = "SELECT isOwned FROM albumInfo INNER JOIN userOwned ON albumInfo.albumId=userOwned.albumId INNER JOIN users ON userOwned.userId=users.usersId WHERE users.usersId=? AND albumInfo.albumId=?;";

    //initialise new statement

    $stmt = mysqli_stmt_init($conn);

    //if to return to main page if album id doesnt exist
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }



    //bind perameters
    mysqli_stmt_bind_param($stmt, "ii", $userId, $albumId);
    //execute
    mysqli_stmt_execute($stmt);

    //stores the result of the statement
    $resultData = mysqli_stmt_get_result($stmt);

    // only display if info
    if ($row = mysqli_fetch_assoc($resultData)) {


        // return the vlue of stored ownership
        return $row['isOwned'];
    }


    mysqli_stmt_close($stmt);
}

function addUserOwnedFavouriteInput($userId, $albumId, $owned, $favourite)
{

    echo '
    <div class="update-owned-favourite" >
    <form action="includes/add-favourite-owned.inc.php" method="post">
    <input type="number" name="own" id="owned_id" style="display:none" value="' . $owned . '">
    <input type="number" name="favourite" id="favourite_id" style="display:none" value="' . $favourite . '">
    <input type="number" name="userId" id="userId" style="display:none" value="' . $userId . '">
    <input type="number" name="albumId" id="albumId" style="display:none" value="' . $albumId . '">
    <input type ="submit" class="pseudo button" style="border-bottom:solid 2px grey;" value ="Update Owned / Favourite">
    </form>
    </div>';
}


function addUserOwnedDB($albumId, $userId, $owned)
{
    include("dbconn.php");

    //Add into userOwned
    $sql = "INSERT INTO `userOwned` (`albumId`, `userId`, `isOwned`) VALUES (?, ?, ?);";

    //initialise new statement

    $stmt = mysqli_stmt_init($conn);

    //if to return to main page if album id doesnt exist
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }





    //bind perameters
    mysqli_stmt_bind_param($stmt, "iii", $albumId, $userId, $owned);
    //execute
    mysqli_stmt_execute($stmt);





    mysqli_stmt_close($stmt);
}

function addUserFavouritedDB($albumId, $userId, $favourite)
{
    include("dbconn.php");

    //Add into userFavourite
    $sql = "INSERT INTO `userFavourite` (`albumId`, `userId`, `isFavourite`) VALUES (?, ?, ?);";

    //initialise new statement

    $stmt = mysqli_stmt_init($conn);

    //if to return to main page if album id doesnt exist
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }





    //bind perameters
    mysqli_stmt_bind_param($stmt, "iii", $albumId, $userId, $favourite);
    //execute
    mysqli_stmt_execute($stmt);





    mysqli_stmt_close($stmt);
}


function updateUserOwnedDB($albumId, $userId, $owned)
{

    include("dbconn.php");

    //edit into userOwned
    $sql = "UPDATE `userOwned` SET `isOwned` = ? WHERE `userOwned`.`albumId` = ? AND `userOwned`.`userId` = ?;";

    //initialise new statement

    $stmt = mysqli_stmt_init($conn);

    //if to return to main page if album id doesnt exist
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }





    //bind perameters
    mysqli_stmt_bind_param($stmt, "iii", $owned, $albumId, $userId);
    //execute
    mysqli_stmt_execute($stmt);





    mysqli_stmt_close($stmt);
}

function updateUserFavouriteDB($albumId, $userId, $owned)
{

    include("dbconn.php");

    //edit into userFavourite
    $sql = "UPDATE `userFavourite` SET `isFavourite` = ? WHERE `userFavourite`.`albumId` = ? AND `userFavourite`.`userId` = ?;";

    //initialise new statement

    $stmt = mysqli_stmt_init($conn);

    //if to return to main page if album id doesnt exist
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }





    //bind perameters
    mysqli_stmt_bind_param($stmt, "iii", $owned, $albumId, $userId);
    //execute
    mysqli_stmt_execute($stmt);





    mysqli_stmt_close($stmt);
}


function createGreyedOut()
{

    echo '
        

    <div class="login-message">

    <h4><a href="../main/login.php" class="pseudo button">Login to add below</a></h4>
    <div class="greyed-rating">
    User Rating
    <i class="fa-regular fa-star" id="login-needed"></i>
    <i class="fa-regular fa-star" id="login-needed"></i>
    <i class="fa-regular fa-star" id="login-needed"></i>
    <i class="fa-regular fa-star" id="login-needed"></i>
    <i class="fa-regular fa-star" id="login-needed"></i>

    </div>
    <div class="greyed-favourite-owned">
    <div class="favourite">Add to Favourites: <i class="fa-regular fa-heart"id="login-needed"></i>
    </div>
    <div class="owned">Add to Owned: <i class="fa-regular fa-dollar-sign"id="login-needed"></i>
    </div>
    </div>
    </div>
 
    ';
}

function addUserReviewArea($albumId)
{
    echo ' <button class="pseudo button" onclick="addReviewBox()" id="but-add-review">Add User Review</button>
    <div class="add-review" style="display:none">

    <form action="includes/add.review.inc.php" method="post">
        <input type="text" name="title" placeholder="Enter Review Title Here.....">
        <textarea name="body" id="" cols="50" rows="4" maxlength="250" placeholder="Enter review here, max 250 characters...."></textarea>
        <input type="hidden" name="albumId" value="' . $albumId . '">
        <input type="submit" class="pseudo button" value="Submit Review for Moderation" id="submit-review">
    </form>

    </div>';
}


function hasUserReview($userId, $albumId)
{

    include("dbconn.php");

    //Select to find if a user has already left a review.
    $sql = "SELECT * FROM review  WHERE userId=? AND albumId=?;";

    //initialise new statement

    $stmt = mysqli_stmt_init($conn);

    //if to return to main page if album id doesnt exist
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }



    //bind perameters
    mysqli_stmt_bind_param($stmt, "ii", $userId, $albumId);
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

function showUserReview($userId, $albumId)
{

    include("dbconn.php");

    //Get individual review
    $sql = "SELECT * FROM review INNER JOIN users ON review.userId=users.usersId WHERE review.userId=? AND albumId=?;";

    //initialise new statement

    $stmt = mysqli_stmt_init($conn);

    //if to return to main page if album id doesnt exist
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }



    //bind perameters
    mysqli_stmt_bind_param($stmt, "ii", $userId, $albumId);
    //execute
    mysqli_stmt_execute($stmt);

    //stores the result of the statement
    $resultData = mysqli_stmt_get_result($stmt);

    // only display if info available
    if ($row = mysqli_fetch_assoc($resultData)) {

        $title = $row['reviewTitle'];
        $body = $row['reviewBody'];
        $isAccepted = $row['isAccepted'];
        $username = $row['usersUid'];
        $timestamp = $row['timeStamp'];

        if ($isAccepted == 0) {

            echo '
            <h4 id="pending">Pending Approval</h4>
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
            <h4>Approved</h4>
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
}

function showAlUserReviews($albumId)
{

    include("dbconn.php");

    //Get all reviews except users as it is will be displayed above
    $sql = "SELECT * FROM review INNER JOIN users ON review.userId=users.usersId WHERE review.albumId=?;";

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

    //Displays all reviews
    while ($row = mysqli_fetch_assoc($resultData)) {

        $title = $row['reviewTitle'];
        $body = $row['reviewBody'];
        $isAccepted = $row['isAccepted'];
        $username = $row['usersUid'];
        $timestamp = $row['timeStamp'];

        if ($isAccepted == 1) {

            echo '
            
        <article class="card">
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
        }
    }

    mysqli_stmt_close($stmt);
}

function addUserReviews($albumId, $userId, $reviewTitle, $reviewBody)
{
    include("dbconn.php");

    //Add into userOwned
    $sql = "INSERT INTO `review` (`userId`, `albumId`, `reviewTitle`, `reviewBody`) VALUES (?,?,?,?);";
    echo "about to run";
    //initialise new statement

    $stmt = mysqli_stmt_init($conn);

    //if to return to main page if album id doesnt exist
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }

    //bind perameters
    mysqli_stmt_bind_param($stmt, "iiss", $userId, $albumId, $reviewTitle, $reviewBody);
    //execute
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
}
