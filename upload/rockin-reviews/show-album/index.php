<?php


include("../main/header.php");
include("includes/functions.php");
// check if album id is set - if not will go to all albums page
if (isset($_GET['albumId'])) {


    //get album id to show
    $albumId = $_GET['albumId'];
    getAlbumAPI($albumId);
    showGenres($albumId);
    showSubGenres($albumId);
} else {
    //returns if user has typed in page into url
    header("location: ../album-filter/index.php");
    exit();
}




?>





<?php

$commScore = getCommunityRating($albumId);
$commScore = round($commScore, 1);

echo  "<script>let commScore=" . $commScore . "</script>";



?>
<script>
    let isFavourite = false;
    let isOwned = false;
</script>

<div class="rating-community">
    Community Rating
    <i class="fa-regular fa-star"></i>
    <i class="fa-regular fa-star"></i>
    <i class="fa-regular fa-star"></i>
    <i class="fa-regular fa-star"></i>
    <i class="fa-regular fa-star"></i>

</div>
<div class="rating-user">


</div>


<?php
if (isset($_SESSION["useruid"])) {




    $userId = $_SESSION['userid'];


    if ((isUserFavouriteSet($userId, $albumId) == NULL)) {
        $isFavouriteSet = 0;
        $isFavourite = 0;
    } else {
        $isFavouriteSet = 1;
        $isFavourite = getUserFavourite($userId, $albumId);
    }


    if ((isUserOwnedSet($userId, $albumId) == NULL)) {

        $isOwnedSet = 0;
        $isOwned = 0;
    } else {
        $isOwnedSet = 1;
        $isOwned = getUserOwned($userId, $albumId);
    }





    if (isUserRatingSet($userId, $albumId)) {
        $userScore = getUserRating($userId, $albumId);


        echo '<script> let userScore = ' . $userScore . '; let isUserAdd=false; </script>';





        echo '

<div class="favourite-owned">
    ';
        createFavouritedDiv($isFavouriteSet, $isFavourite);
        createOwneddDiv($isOwnedSet, $isOwned);
        echo '</div>';
        addUserOwnedFavouriteInput($userId, $albumId, $isOwned, $isFavourite);
    } else {


        echo '<script> let userScore = -1; let isUserAdd = true;</script>';
        addUserScoreDivs($albumId);
        echo '
        <div class="favourite-owned">
        ';
        createFavouritedDiv($isFavouriteSet, $isFavourite);
        createOwneddDiv($isOwnedSet, $isOwned);
        echo '</div>';
        addUserOwnedFavouriteInput($userId, $albumId, $isOwned, $isFavourite);
    }
} else {
    echo '<script> let userScore = -2;</script>';
    createGreyedOut();
}
?>


<br>
<hr>



<div class="album-description">


</div>



<div class="user-reviews">

    <h2>User Reviews</h2>

    <?php
    if (isset($_SESSION["useruid"])) {

        if (hasUserReview($userId, $albumId)) {
            showUserReview($userId, $albumId);
        } else {
            addUserReviewArea($albumId);
        }
    }


    ?>



    <div class="all-reviews">



        <?php
        showAlUserReviews($albumId);
        ?>

    </div>

</div>


</div>

<script src="js/app.js" type="text/javascript"></script>

<script>
    displayStars(commScore, "com", false);
    displayStars(userScore, "user", isUserAdd);
    // toggleOwned(0);
    // toggleFavourite(0);
</script>




</body>

</html>