<?php
//disable caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


// Set session cookie to be secure and HTTP only
$cookieParams = session_get_cookie_params();
session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], true, true);



// Start session
session_start();

//regenerate session id to prevent session hijacking
session_regenerate_id(true);

// Get the current script name
$currentScript = basename($_SERVER['SCRIPT_NAME']);

// Check if user is logged in, but skip the check if the current script is login.php
if ($currentScript != 'login.php' && !isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}

// Logout logic
if (isset($_POST['logout'])) {
    // Destroy session and redirect to index.php
    session_destroy();
    header("Location: index.php");
    exit();
}

// Check if user is admin
$isAdmin = false;
if (isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] == true) {
    $isAdmin = true;
}

// Check if user is logged in
// Check if the user_token cookie exists and is not expired
if (isset($_COOKIE['user_token']) && !isExpired($_COOKIE['user_token'])) {
    header("Location: welcome.php"); // Redirect to welcome.php
    exit();
}

function isExpired($cookieValue)
{
    // Check the expiration time of the cookie
    $expirationTime = $_COOKIE['user_token']; // Assuming the cookie value is the expiration timestamp

    return time() > $expirationTime; // Return true if the current time is greater than the expiration time
}
