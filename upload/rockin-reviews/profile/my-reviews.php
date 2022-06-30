<?php


include("../main/header.php");
include("includes/functions.php");

//only allows signed in users entry
if (!isset($_SESSION['userid'])) { #
    header("location: ../main/index.php");
    exit();
}

$userId = $_SESSION['userid'];

?>


<div class="my-reviews-show">

    <h1>My Reviews</h1>


</div>

<div class="album-choice">
    <button onclick='showHideChoice("approved")' id="approved-button">Show Accepted</button>
    <button onclick='showHideChoice("pending")' id="pending-button">Show Pending</button>

</div>

<div class="reviews">



    <div class="approved" id="approved" style="display:none">
        <h2>All Aproved Reviews</h2>
        <div class="review-container">
            <?php
            showReviews($userId, 1);
            ?>
        </div>

    </div>
    <div class="pending" id='pending' style="display:none">
        <h2>Pending</h2>
        <div class="review-container">
            <?php
            showReviews($userId, 0);
            ?>
        </div>
    </div>


</div>


<script src="js/app.js"> </script>
</body>

</html>