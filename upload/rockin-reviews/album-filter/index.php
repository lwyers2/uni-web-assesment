<?php

include("includes/dbconn.php");
include("includes/functions.php");




include("../main/header.php");

?>








<div class="title">
    <h1>Albums</h1>
</div>

<?php
filterAlbums();
?>

<div class="filter-buttons">
    <button onclick="showAll()" class="pseudo button icon-picture" id="view-all-button">Hide</button>
    <a href="../search-albums/index.php" class="pseudo button icon-picture">Search</a>





</div>


<div class="show-albums" id="hidden">

    <h2 id="choice">All Albums</h2>
    <div class="album-container">


        <?php




        showAll();

        ?>

    </div>
</div>
</div>



<script src="js/app.js">

</script>
</body>

</html>