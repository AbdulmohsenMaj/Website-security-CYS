<?php
include 'session.php';
include 'connection.php';

// Retrieve form data
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];
$created_at = date('Y-m-d H:i:s'); // Get the current date and time

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO Feedback (name, email, message, created_at) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $message, $created_at);

$stmt->execute();

$stmt->close();
$conn->close();

header("Location: feedback.php"); // Redirect back to the feedback page
exit();
