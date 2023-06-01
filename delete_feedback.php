<?php
include 'session.php';
include 'connection.php';

// Check if user is admin
if (!$isAdmin) {
    header("Location: feedback.php");
    exit();
}

// Check if feedback_id is set and is a valid integer
if (!isset($_POST['feedback_id']) || !filter_var($_POST['feedback_id'], FILTER_VALIDATE_INT)) {
    header("Location: feedback.php");
    exit();
}

$feedback_id = $_POST['feedback_id'];

// Prepare and bind
$stmt = $conn->prepare("DELETE FROM Feedback WHERE id = ?");
if ($stmt === false) {
    header("Location: feedback.php");
    exit();
}

$stmt->bind_param("i", $feedback_id);

if ($stmt->execute() === false) {
    // Handle error - perhaps by logging and redirecting to an error page
    error_log($stmt->error);
    header("Location: feedback.php");
    exit();
}

$stmt->close();
$conn->close();

header("Location: feedback.php");
exit();
