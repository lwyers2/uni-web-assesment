<?php


include("../main/header.php");
include("includes/functions.php");

//only allows signed in ADMIN users entry
if ((!isset($_SESSION['userid'])) && (!$_SESSION['userTypeId'] == 0)) {
    header("location: ../main/index.php");
    exit();
}

// check if album id is set - if not will go back to admin page
if (isset($_GET['albumId'])) {


    //get album id to show
    $albumId = $_GET['albumId'];
} else {
    //returns if user has typed in page into url
    header("location: index.php");
    exit();
}
?>



<div class="edit-choice">
    <div class="edit-album-title">
        <h1>Edit Album</h1>
        <?php
        $albumName = getAlbumName($albumId);
        echo '<h2>' . $albumName . '</h2>';
        ?>
    </div>
    <div class="edit-choice-buttons">
        <!-- Added in required for all fields for simple validation - backen also checks input-->
        <button onclick="editBox('rank')">Rank</button>
        <button onclick="editBox('albumname')">Name</button>
        <button onclick="editBox('cover')">Cover</button>
        <button onclick="editBox('year')"> Year </button>
        <button onclick="editBox('artist')">Artist</button>
        <button onclick="editBox('genre')">Genre</button>
        <button onclick="editBox('subgenre')">Sub Genre</button>

    </div>
    <a href="albums-admin.php"><button>Back</button></a>
</div>

<div class="edit-rank" style="display:none">
    <h2>Edit Rolling Stone Ranking</h2>
    <div class="edit-container">
        <!-- Added in required for all fields for simple validation - backen also checks input-->
        <form action="includes/album-update.inc.php" method="post">
            <input type="hidden" name="albumId" value="<?php echo $albumId ?>">
            <input type="number" name="rank" required>
            <input type="submit" name="confirm" value="Confirm Changes">
        </form>
    </div>

</div>

<div class="edit-albumname" style="display:none">
    <h2>Album Name</h2>
    <div class="edit-container">
        <!-- Added in required for all fields for simple validation - backen also checks input-->
        <form action="includes/album-update.inc.php" method="post">
            <input type="hidden" name="albumId" value="<?php echo $albumId ?>">
            <input type="text" name="albumname" required>
            <input type="submit" name="confirm" value="Confirm Changes">
        </form>



    </div>
</div>

<div class="edit-cover" style="display:none">
    <h2>Album Cover</h2>
    <div class="edit-container">
        <!-- Added in required for all fields for simple validation - backen also checks input-->
        <form action="includes/album-update.inc.php" method="post">
            <input type="hidden" name="albumId" value="<?php echo $albumId ?>">
            <input type="text" name="cover" required>
            <input type="submit" name="confirm" value="Confirm Changes">
        </form>



    </div>
</div>

<div class="edit-year" style="display:none">
    <h2>Album Realease Year</h2>
    <div class="edit-container">
        <!-- Added in required for all fields for simple validation - backen also checks input-->
        <form action="includes/album-update.inc.php" method="post">
            <input type="hidden" name="albumId" value="<?php echo $albumId ?>">
            <input type="number" name="year" required>
            <input type="submit" name="confirm" value="Confirm Changes">
        </form>



    </div>
</div>

<div class="edit-artist" style="display:none">
    <h2>Album Artist</h2>
    <div class="edit-container">
        <!-- Added in required for all fields for simple validation - backen also checks input-->
        <form action="includes/album-update.inc.php" method="post">
            <input type="hidden" name="albumId" value="<?php echo $albumId ?>">
            <input type="text" name="artist" required>
            <input type="submit" name="confirm" value="Confirm Changes">
        </form>



    </div>
</div>

<div class="edit-genre" style="display:none">
    <h2>Album Genre</h2>
    <div class="edit-container">
        <!-- Added in required for all fields for simple validation - backen also checks input-->
        <form action="genre-update.php" method="post">
            <input type="hidden" name="albumId" value="<?php echo $albumId ?>">
            <input type="submit" name="genre" value="Edit Genres">
        </form>



    </div>
</div>

<div class="edit-subgenre" style="display:none">
    <h2>Album Subgenre</h2>
    <div class="edit-container">
        <!-- Added in required for all fields for simple validation - backen also checks input-->
        <form action="genre-update.php" method="post">
            <input type="hidden" name="albumId" value="<?php echo $albumId ?>">
            <input type="submit" name="subgenre" value="Edit Sub Genres">
        </form>



    </div>
</div>

</div>






<script src="js/app.js"> </script>
</body>

</html>