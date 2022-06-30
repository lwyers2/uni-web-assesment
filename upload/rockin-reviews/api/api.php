<?php


header("Content-Type: application/json");
include("dbconn.php");



//show an album
if ((isset($_GET['showAlbum']))) {

    $albumId = $_GET['showAlbum'];
    // get all information from album info using album ID - GET from album link elsewhere
    $sql = "SELECT * FROM albumInfo INNER JOIN artistInfo ON albumInfo.artistId= artistInfo.artistInfoId WHERE albumId =?;";

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

    // build a response array
    $api_response = array();

    if ($row = mysqli_fetch_assoc($resultData)) {

        array_push($api_response, $row);
    }

    // encode the response as JSON
    $response = json_encode($api_response);

    // echo out the response
    echo $response;
    mysqli_stmt_close($stmt);
}

if (isset($_GET['showGenre'])) {
    $albumId = $_GET['showGenre'];

    // get all information from album info using album ID - GET from album link elsewhere
    $sql = "SELECT * FROM albumInfo INNER JOIN albumGenre ON albumInfo.albumId=albumGenre.albumId INNER JOIN genre on albumGenre.genreId=genre.genreId WHERE albumInfo.albumId = ?;";

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

    // build a response array
    $api_response = array();

    while ($row = mysqli_fetch_assoc($resultData)) {

        array_push($api_response, $row);
    }

    // encode the response as JSON
    $response = json_encode($api_response);

    // echo out the response
    echo $response;
    mysqli_stmt_close($stmt);
}


if (isset($_GET['showSubGenre'])) {
    $albumId = $_GET['showSubGenre'];

    // get all information from album info using album ID - GET from album link elsewhere
    $sql = "SELECT * FROM albumInfo INNER JOIN albumSubGenre ON albumInfo.albumId=albumSubGenre.albumId INNER JOIN genre on albumSubGenre.genreId=genre.genreId WHERE albumInfo.albumId = ?;";

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

    // build a response array
    $api_response = array();

    while ($row = mysqli_fetch_assoc($resultData)) {

        array_push($api_response, $row);
    }

    // encode the response as JSON
    $response = json_encode($api_response);

    // echo out the response
    echo $response;
    mysqli_stmt_close($stmt);
}

//community rating
if ((isset($_GET['commRating']))) {

    $albumId = $_GET['commRating'];

    //Select to find a user's uniqe score Inner joining albuminfo on userScore and user information.
    $sql = "SELECT AVG (ALL score) AS score FROM userScore WHERE albumId=? ;";

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

    // build a response array
    $api_response = array();

    while ($row = mysqli_fetch_assoc($resultData)) {

        array_push($api_response, $row);
    }

    // encode the response as JSON
    $response = json_encode($api_response);

    // echo out the response
    echo $response;
    mysqli_stmt_close($stmt);
}

//searches



if ((isset($_GET['q'])) && (isset($_GET['type'])) && ($_GET['type'] == 's')) {


    $searchQuery = $conn->real_escape_string($_GET["q"]);


    $searchQuery = strtolower($searchQuery);



    $sql = "SELECT * FROM albumInfo INNER JOIN albumSubGenre ON albumInfo.albumId=albumSubGenre.albumId INNER JOIN genre on albumSubGenre.genreId=genre.genreId WHERE genreName LIKE CONCAT( '%',?,'%');";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }



    //bind perameters
    mysqli_stmt_bind_param($stmt, "s", $searchQuery);
    //execute
    mysqli_stmt_execute($stmt);

    //stores the result of the statement
    $resultData = mysqli_stmt_get_result($stmt);

    // build a response array
    $api_response = array();

    while ($row = mysqli_fetch_assoc($resultData)) {

        array_push($api_response, $row);
    }

    // encode the response as JSON
    $response = json_encode($api_response);

    // echo out the response
    echo $response;
    mysqli_stmt_close($stmt);
}




if ((isset($_GET['q'])) && (isset($_GET['type'])) && ($_GET['type'] == 'y')) {


    $searchQuery = $conn->real_escape_string($_GET["q"]);
    $searchQuery = strtolower($searchQuery);

    $sql = "SELECT * FROM albumInfo WHERE albumYear  LIKE CONCAT( '%',?,'%');";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }


    //bind perameters
    mysqli_stmt_bind_param($stmt, "s", $searchQuery);
    //execute
    mysqli_stmt_execute($stmt);

    //stores the result of the statement
    $resultData = mysqli_stmt_get_result($stmt);

    // build a response array
    $api_response = array();

    while ($row = mysqli_fetch_assoc($resultData)) {

        array_push($api_response, $row);
    }

    // encode the response as JSON
    $response = json_encode($api_response);

    // echo out the response
    echo $response;
    mysqli_stmt_close($stmt);
}

if ((isset($_GET['q'])) && (isset($_GET['type'])) && ($_GET['type'] == 'ar')) {



    $searchQuery = $conn->real_escape_string($_GET["q"]);


    $searchQuery = strtolower($searchQuery);


    //user CONCAT FOR LIKE

    $sql = "SELECT * FROM albumInfo INNER JOIN artistInfo ON albumInfo.artistId= artistInfo.artistInfoId WHERE artistName LIKE CONCAT( '%',?,'%');";




    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }



    //bind perameters
    mysqli_stmt_bind_param($stmt, "s", $searchQuery);
    //execute
    mysqli_stmt_execute($stmt);

    //stores the result of the statement
    $resultData = mysqli_stmt_get_result($stmt);

    // build a response array
    $api_response = array();

    while ($row = mysqli_fetch_assoc($resultData)) {

        array_push($api_response, $row);
    }

    // encode the response as JSON
    $response = json_encode($api_response);

    // echo out the response
    echo $response;
    mysqli_stmt_close($stmt);
}


if ((isset($_GET['q'])) && (isset($_GET['type'])) && ($_GET['type'] == 'al')) {


    $searchQuery = $conn->real_escape_string($_GET["q"]);


    $searchQuery = strtolower($searchQuery);


    //user CONCAT FOR LIKE

    $sql = "SELECT * FROM albumInfo  WHERE albumName LIKE CONCAT( '%',?,'%');";




    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }



    //bind perameters
    mysqli_stmt_bind_param($stmt, "s", $searchQuery);
    //execute
    mysqli_stmt_execute($stmt);

    //stores the result of the statement
    $resultData = mysqli_stmt_get_result($stmt);

    // build a response array
    $api_response = array();

    while ($row = mysqli_fetch_assoc($resultData)) {

        array_push($api_response, $row);
    }

    // encode the response as JSON
    $response = json_encode($api_response);

    // echo out the response
    echo $response;
    mysqli_stmt_close($stmt);
}



if ((isset($_GET['q'])) && (isset($_GET['type'])) && ($_GET['type'] == 'g')) {

    $searchQuery = $conn->real_escape_string($_GET["q"]);
    $searchQuery = strtolower($searchQuery);

    $sql = "SELECT * FROM albumInfo INNER JOIN albumGenre ON albumInfo.albumId=albumGenre.albumId INNER JOIN genre on albumGenre.genreId=genre.genreId WHERE genreName LIKE CONCAT( '%',?,'%');";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/index.php?error=stmtfailed");
        exit();
    }


    //bind perameters
    mysqli_stmt_bind_param($stmt, "s", $searchQuery);
    //execute
    mysqli_stmt_execute($stmt);

    //stores the result of the statement
    $resultData = mysqli_stmt_get_result($stmt);

    // build a response array
    $api_response = array();

    while ($row = mysqli_fetch_assoc($resultData)) {

        array_push($api_response, $row);
    }

    // encode the response as JSON
    $response = json_encode($api_response);

    // echo out the response
    echo $response;
    mysqli_stmt_close($stmt);
}
