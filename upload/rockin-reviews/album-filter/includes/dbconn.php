<?php
$host = "lwyers01.webhosting6.eeecs.qub.ac.uk";
$user = "lwyers01";
$pw = "J62CHB4kV8w79Dl5";
$db = "lwyers01";

$conn = new mysqli($host, $user, $pw, $db);

if ($conn->connect_error) {

    $check = "Not connected " . $conn->connect_error;
}
