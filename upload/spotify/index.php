<?php

include("functions.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spotify Api</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="app.js"></script>

</head>

<body>






    <body onload="onPageLoad()">
        <div class="container">
            <div id="tokenSection" class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="clientId" class="form-label">Client Id</label>
                        <input type="text" class="form-control" id="clientId" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="clientSecret" class="form-label">Client Secret</label>
                        <input type="text" class="form-control" id="clientSecret" placeholder="">
                    </div>
                    <input class="btn btn-primary btn-lg" type="button" onclick="requestAuthorization()" value="Request Authorization"><br />
                </div>

            </div>

            <div class="row" id="deviceSection">
                <div class="col">
                    <div class="mb-3">
                        <label for="devices" class="form-label">Devices</label>
                        <select id="devices" class="form-control">
                        </select>
                        <input class="btn btn-primary btn-sm mt-3" type="button" onclick="refreshDevices()" value="Refresh Devices">
                    </div>
                </div>
            </div>

            <div class="row" id="searchSection">
                <div class="col">
                    <div class="mb-3">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" id="album-name" placeholder="album">
                        <input type="text" id="artist-name" placeholder="artist">
                        <input class="btn btn-primary btn-sm mt-3" type="button" onclick="searchAlbum()" value="Search Album">
                    </div>
                </div>
            </div>

            <div class="row" id="results">
                <div class="col">
                    <div class="display-results" id="display-results">

                    </div>
                </div>
            </div>

            <?php
            searchArt();
            takeTwo();
            ?>

        </div>


    </body>

</html>