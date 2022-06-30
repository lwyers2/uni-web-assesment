<?php


include("../main/header.php");
include("includes/functions.php");

//only allows signed in ADMIN users entry
if ((!isset($_SESSION['userid'])) && (!$_SESSION['userTypeId'] == 0)) {
    header("location: ../../main/index.php");
    exit();
}

$userId = $_SESSION['userid'];

?>


<div class="my-reviews-show">

    <h1>Approve/Decline Reviews</h1>


</div>



<div class="reviews">



    <div class="pending" id='pending'>
        <h2>Pending</h2>
        <div class="review-container">
            <?php
            showReviews();
            ?>
        </div>
    </div>


</div>


<script src="js/app.js"> </script>
</body>

</html>