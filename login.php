<?php
require_once 'session.php';
require_once 'connection.php';

$username = $_POST["username"];
$password = hash('sha256', $_POST["password"]); // Securely storing password

// Prepare and bind
$stmt = $conn->prepare("SELECT * FROM Users WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $username, $password);

$stmt->execute();

$result = $stmt->get_result();
if ($result->num_rows > 0) {
  $user = $result->fetch_assoc(); // Fetch the user data
  $_SESSION["username"] = $user['username']; // Start the session
  $_SESSION["email"] = $user['email']; //retrieve email from database
  $_SESSION["isAdmin"] = $user['isAdmin']; //retrieve admin roles from database
  // Set a presistent cookie that lasts for 1 minute
  setcookie("username", $user['username'], time() + 60, "/");

  header('Location: welcome.php'); // Redirect to a new page
  //regenerate session id each time user logs in
  session_regenerate_id(true);
} else {
  header("Location: index.php?error=1");
  exit();
}


$stmt->close();
$conn->close();
