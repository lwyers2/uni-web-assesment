<?php


include("../main/header.php");
include("includes/functions.php");

//only allows signed in ADMIN users entry
if ((!isset($_SESSION['userid'])) && (!$_SESSION['userTypeId'] == 0)) {
    header("location: ../main/index.php");
    exit();
}


?>






<div class="my-info">



    <?php


    showAdminUserInfo($_SESSION['userid']);


    if (isset($_GET['review'])) {
        if ($_GET['review'] == 'approved') {
            echo "Review Approved And Added!";
        } else if ($_GET['review'] == 'deleted') {
            echo "Review Deleted From System";
        } else if ($_GET['review'] == 'error') {
            echo "Error deleting record, please contact administrator";
        }
    }

    if (isset($_GET['albumdelete=1'])) {
        echo "Album deleted";
    }
    ?>



</div>


<div class="my-admin">

    <article class="card">
        <header>
            <h3>User Account Admin</h3>
        </header>
        <footer>
            <a href="users-admin.php"><button class="pseudo button">Edit User Accounts</button></a>
        </footer>
    </article>



    <article class="card">
        <header>
            <h3>Moderate Reviews</h3>
        </header>
        <footer>
            <a href="reviews-admin.php"><button class="pseudo button">Edit All Reviews</button></a>
        </footer>
    </article>


    <article class="card">
        <header>
            <h3>Album Admin</h3>
        </header>
        <footer>
            <a href="albums-admin.php"><button class="pseudo button">Edit All Albums</button></a>
            <a href="albums-add.php"><button class="pseudo button">Add Album</button></a>

        </footer>
    </article>


</div>

















</div>








<script src="js/app.js"> </script>
</body>

</html>