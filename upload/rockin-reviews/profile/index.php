<?php


include("../main/header.php");
include("includes/functions.php");

//only allows signed in users entry
if (!isset($_SESSION['userid'])) { #
    header("location: ../main/index.php");
    exit();
}



?>






<div class="my-info">

    <?php


    showUserInfo($_SESSION['userid']);

    ?>



    <div class="edit-details">

        <h3>Edit Details</h3>

        <?php
        showUserInfoEdit($_SESSION['userid']);
        ?>




    </div>

</div>


<div class="my-albums">

    <article class=" card">
        <header>
            <h3>My Albums</h3>
        </header>
        <footer>
            <a href="my-albums.php"><button class="pseudo button">Show All Favourite and Owned</button></a>
        </footer>
    </article>



    <article class="card">
        <header>
            <h3>My Reviews</h3>
        </header>
        <footer>
            <a href="my-reviews.php"><button class="pseudo button">Show All Accepted and Pending</button></a>
        </footer>
    </article>


</div>


<div class="delete-profile">




    <article class=" card">
        <header>
            <h3>Delete Profile</h3>
        </header>
        <footer>
            <p>Do you wish to permenantly delete your profile?</p>
            <a href="delete.php"><button>Delete Profile</button></a>
        </footer>
    </article>

</div>















</div>








<script src="js/app.js"> </script>
</body>

</html>