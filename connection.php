<?php

// Admin connection details
$admin_servername = "localhost";
$admin_username = "mohsen";
$admin_password = "6565";
$admin_dbname = "webserver";

// Limited privilege connection details
$limited_servername = "localhost";
$limited_username = "user";
$limited_password = "6565";
$limited_dbname = "webserver";

// Function to establish the admin connection
function establishAdminConnection()
{
  global $admin_servername, $admin_username, $admin_password, $admin_dbname;

  $conn = new mysqli($admin_servername, $admin_username, $admin_password, $admin_dbname);

  // Check admin connection
  if ($conn->connect_error) {
    die("Admin Connection failed: " . $conn->connect_error);
  }

  return $conn;
}

// Function to establish the limited privilege connection
function establishLimitedConnection()
{
  global $limited_servername, $limited_username, $limited_password, $limited_dbname;

  $conn = new mysqli($limited_servername, $limited_username, $limited_password, $limited_dbname);

  // Check limited privilege connection
  if ($conn->connect_error) {
    die("Limited Connection failed: " . $conn->connect_error);
  }

  return $conn;
}

// Check if the user is logged in as an admin or not
if (isset($_SESSION['isAdmin'])) {
  $conn = establishAdminConnection();
} else {
  $conn = establishLimitedConnection();
}
