<?php

include("dbconn.php");
include("functions.php");

printArtistInsert();



printAlbumInsert();


printAllGenres();



insertIntoGenreAlbum();

insertIntoSubGenreAlbum();

createReviewTable();

createReviewTable();

createUserFavouriteTable();

createUserOwnedTable();

createUsersTable();

createUserScores();

foreignKeys();




function printArtistInsert()
{

    echo "CREATE TABLE `test`.`artistInfo` ( `artistId` INT(11) NOT NULL AUTO_INCREMENT , `artistName` VARCHAR(80) NOT NULL , PRIMARY KEY (`artistId`), UNIQUE (`artistName`)) ENGINE = InnoDB; <br>";

    if (($open = fopen("album_list.csv", "r")) !== FALSE) {


        while (($data = fgetcsv($open, 10000, ",")) !== FALSE) {
            $array[] = $data[3];
        }

        fclose($open);
    }




    $array = array_unique($array);



    //has to loop through original arrays length as $i is still same value
    for ($i = 0; $i < 500; $i++) {

        if (!(empty($array[$i]))) {
            echo 'INSERT INTO `artistInfo` (`artistId`, `artistName`) VALUES (NULL, "' . $array[$i] . '"); <br>';
        }
    }

    // echo "<pre>";
    // //To display array data
    // var_dump($array);
    // echo "</pre>";
}

function printAlbumInsert()
{

    echo "CREATE TABLE `test`.`albumInfo` ( `albumId` INT NOT NULL AUTO_INCREMENT , `albumName` VARCHAR(255) NOT NULL , `albumImgUrl` VARCHAR(255) NOT NULL DEFAULT 'Placeholder' , `ranking` INT NOT NULL , `artistId` INT NOT NULL , `albumYear` INT(4) NOT NULL , PRIMARY KEY (`albumId`)) ENGINE = InnoDB;";

    if (($open = fopen("album_list.csv", "r")) !== FALSE) {


        while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
            $array[] = $data;
        }

        fclose($open);
    }

    for ($i = 0; $i < count($array); $i++) {

        if (!(empty($array[$i]))) {

            $albumId =  getArtistId($array[$i][3]);

            // echo "{$array[$i][3]} = {$albumId} <br>";

            echo 'INSERT INTO `albumInfo` (`albumId`, `albumName`, `albumImgUrl`, `ranking`, `artistId`, `albumYear`) VALUES (NULL, "' . $array[$i][2] . '", "Placeholder", "' . $array[$i][0] . '", "' . $albumId . '", "' . $array[$i][1] . '");<br>';
        }
    }
}



function printAllGenres()
{

    echo "CREATE TABLE `test`.`genre` ( `genreId` INT(11) NOT NULL AUTO_INCREMENT , `genreName` VARCHAR(100) NOT NULL , PRIMARY KEY (`genreId`), UNIQUE (`genreName`)) ENGINE = InnoDB; <br>";

    if (($open = fopen("genres-master.csv", "r")) !== FALSE) {


        while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
            $array[] = $data;
        }

        fclose($open);
    }



    for ($i = 0; $i < count($array); $i++) {

        for ($j = 1; $j < count($array[$i]); $j++) {

            $genres[] = $array[$i][$j];
        }
    }

    $genres = array_unique($genres);

    for ($i = 0; $i < count($array); $i++) {

        if (!empty($genres[$i])) {

            echo "INSERT INTO `genre` (`genreId`, `genreName`) VALUES (NULL, '$genres[$i]'); <br>";
        }
    }



    //echo "ALTER TABLE `albumInfo` ADD FOREIGN KEY (`artistId`) REFERENCES `artistInfo`(`artistId`) ON DELETE RESTRICT ON UPDATE RESTRICT;";
}







function insertIntoGenreAlbum()
{




    echo "CREATE TABLE `test`.`albumGenre` ( `albumId` INT NOT NULL , `genreId` INT NOT NULL ) ENGINE = InnoDB; <br>";

    if (($open = fopen("genre.csv", "r")) !== FALSE) {


        while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
            $array[] = $data;
        }

        fclose($open);
    }



    for ($i = 0; $i < count($array); $i++) {

        for ($j = 1; $j < count($array[$i]); $j++) {

            $rank = $array[$i][0];

            $albumId = getAlbumIdRank($rank);

            if (!empty($array[$i][$j])) {

                $genreId = getGenreId($array[$i][$j]);



                echo "INSERT INTO `albumGenre` (`albumId`, `genreId`) VALUES ({$albumId}, {$genreId}); <br>";
            }
        }
    }

    echo "ALTER TABLE `albumGenre`
    ADD KEY `albumId` (`albumId`),
    ADD KEY `genreId` (`genreId`);";
}

function insertIntoSubGenreAlbum()
{
    echo "CREATE TABLE `test`.`albumSubGenre` ( `albumId` INT NOT NULL , `genreId` INT NOT NULL ) ENGINE = InnoDB; <br>";

    if (($open = fopen("sub_genre.csv", "r")) !== FALSE) {


        while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
            $array[] = $data;
        }

        fclose($open);
    }



    for ($i = 0; $i < count($array); $i++) {

        for ($j = 1; $j < count($array[$i]); $j++) {

            $rank = $array[$i][0];

            $albumId = getAlbumIdRank($rank);

            if (!empty(getGenreId($array[$i][$j]))) {

                $genreId = getGenreId($array[$i][$j]);



                echo "INSERT INTO `albumSubGenre` (`albumId`, `genreId`) VALUES ({$albumId}, {$genreId}); <br>";
            }
        }
    }

    echo "ALTER TABLE `albumSubGenre`
    ADD KEY `albumId` (`albumId`),
    ADD KEY `genreId` (`genreId`);";
}

function createReviewTable()
{
    echo "CREATE TABLE `test`.`review` (
        `userId` int(11) NOT NULL,
        `albumId` int(11) NOT NULL,
        `reviewTitle` varchar(60) NOT NULL,
        `reviewBody` varchar(250) NOT NULL,
        `isAccepted` tinyint(4) NOT NULL DEFAULT 0,
        `timeStamp` datetime NOT NULL DEFAULT current_timestamp()
      ) ENGINE=InnoDB;";

    echo "ALTER TABLE `review`
    ADD PRIMARY KEY (`userId`,`albumId`),
    ADD KEY `albumId` (`albumId`);";
}


function createUserFavouriteTable()
{

    echo "CREATE TABLE `userFavourite` (
        `albumId` int(11) NOT NULL,
        `userId` int(11) NOT NULL,
        `isFavourite` tinyint(4) NOT NULL
      ) ENGINE=InnoDB;";

    echo "ALTER TABLE `userFavourite`
    ADD PRIMARY KEY (`albumId`,`userId`),
    ADD KEY `userId` (`userId`);";
}





function createUserOwnedTable()
{

    echo "CREATE TABLE `userOwned` (
      `albumId` int(11) NOT NULL,
      `userId` int(11) NOT NULL,
      `isOwned` tinyint(1) NOT NULL
    ) ENGINE=InnoDB;";

    echo "ALTER TABLE `userOwned`
    ADD PRIMARY KEY (`albumId`,`userId`),
    ADD KEY `userId` (`userId`);";
}





function createUsersTable()
{
    echo "CREATE TABLE `users` (
        `usersId` int(11) NOT NULL,
        `usersName` varchar(50) NOT NULL,
        `usersEmail` varchar(128) NOT NULL,
        `usersUid` varchar(30) NOT NULL,
        `usersPwd` varchar(128) NOT NULL,
        `userTypeId` int(11) NOT NULL DEFAULT 1
      ) ENGINE=InnoDB";

    echo "ALTER TABLE `users`
      ADD PRIMARY KEY (`usersId`),
      ADD UNIQUE KEY `usersEmail` (`usersEmail`),
      ADD UNIQUE KEY `usersUid` (`usersUid`);";

    echo "ALTER TABLE `users`
      MODIFY `usersId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
    COMMIT;";
}


function createUserScores()
{

    echo "CREATE TABLE `userScore` (
        `albumId` int(11) NOT NULL,
        `userId` int(11) NOT NULL,
        `score` tinyint(4) NOT NULL
      ) ENGINE=InnoDB";


    echo "ALTER TABLE `userScore`
    ADD PRIMARY KEY (`albumId`,`userId`),
    ADD KEY `userId` (`userId`);";
}




function foreignKeys()
{
    echo "ALTER TABLE `review`
    ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`albumId`) REFERENCES `albumInfo` (`albumId`),
    ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `users` (`usersId`);
     COMMIT;";


    echo "ALTER TABLE `userFavourite`
    ADD CONSTRAINT `userFavourite_ibfk_1` FOREIGN KEY (`albumId`) REFERENCES `albumInfo` (`albumId`),
    ADD CONSTRAINT `userFavourite_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `users` (`usersId`);
    COMMIT;";


    echo "ALTER TABLE `userOwned`
    ADD CONSTRAINT `userOwned_ibfk_1` FOREIGN KEY (`albumId`) REFERENCES `albumInfo` (`albumId`),
    ADD CONSTRAINT `userOwned_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `users` (`usersId`);
    COMMIT;";


    echo "ALTER TABLE `userScore`
    ADD CONSTRAINT `userScore_ibfk_1` FOREIGN KEY (`albumId`) REFERENCES `albumInfo` (`albumId`),
    ADD CONSTRAINT `userScore_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `users` (`usersId`);
    COMMIT;";


    echo "ALTER TABLE `albumGenre`
    ADD CONSTRAINT `albumGenre_ibfk_1` FOREIGN KEY (`albumId`) REFERENCES `albumInfo` (`albumId`),
    ADD CONSTRAINT `albumGenre_ibfk_2` FOREIGN KEY (`genreId`) REFERENCES `genre` (`genreId`);
    COMMIT;";

    echo "ALTER TABLE `albumInfo` ADD FOREIGN KEY (`artistId`) REFERENCES `artistInfo`(`artistId`) ON DELETE RESTRICT ON UPDATE RESTRICT;";



    echo "ALTER TABLE `albumSubGenre`
    ADD CONSTRAINT `albumSubGenre_ibfk_1` FOREIGN KEY (`albumId`) REFERENCES `albumInfo` (`albumId`),
    ADD CONSTRAINT `albumSubGenre_ibfk_2` FOREIGN KEY (`genreId`) REFERENCES `genre` (`genreId`);
    COMMIT;";
}
