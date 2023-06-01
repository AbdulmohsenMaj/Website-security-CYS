<?php
//user
$servername = "localhost";
$db_username = "user";
$db_password = "6565";
$dbname = "webserver";

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
