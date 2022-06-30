<?php

include("header.php");

?>


<div class="title">
    <h1>Albums</h1>
    <h3>Filter By:</h3>
    <div class="links">
        <a href="../album-filter/artist.php" class="pseudo button icon-picture">Artist</a>
        <a href="../album-filter/genre.php" class="pseudo button icon-picture">Genre</a>
        <a href="../album-filter/subgenre.php" class="pseudo button icon-picture">SubGenre</a>
        <a href="../album-filter/year.php" class="pseudo button icon-picture">Year</a>
    </div>

</div>





<div class="highest">

    <div class="number1">


        <?php

        getTopRated();
        ?>


    </div>
    <div class="best">


        <?php

        getHighestScore();
        getMostFavourites();
        getMostOwned();
        getMostReviewed();
        ?>



    </div>
</div>

<h2 id="trending-title">Trending</h2>
<div class="trending">

    <?php
    getTrending();
    ?>
</div>



</div>
</div>

</body>

</html>