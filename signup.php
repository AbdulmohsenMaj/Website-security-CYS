<?php
include 'limited_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate input
    if (empty($email) || empty($username) || empty($password)) {
        header("Location: signupPage.php?error=1"); // Error 1: Empty input fields
        exit();
    }

    // Check if email or username already exists
    $stmt = $conn->prepare("SELECT email, username FROM Users WHERE email = ? OR username = ?");
    if (!$stmt) {
        header("Location: signupPage.php?error=2"); // Error 2: Failed to prepare SQL statement
        exit();
    }

    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->close();
        $conn->close();
        header("Location: signupPage.php?error=4"); // Error 4: Duplicate email or username
        exit();
    }

    $stmt->close();

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO Users (email, username, password) VALUES (?, ?, ?)");
    if (!$stmt) {
        header("Location: signupPage.php?error=2"); // Error 2: Failed to prepare SQL statement
        exit();
    }

    $hashed_password = hash('sha256', $password); // Securely storing password
    $stmt->bind_param("sss", $email, $username, $hashed_password);

    $stmt->execute();

    if ($stmt->affected_rows <= 0) {
        header("Location: signupPage.php?error=3"); // Error 3: Failed to insert into database
        exit();
    }

    $stmt->close();
    $conn->close();

    header('Location: index.php'); // Redirect to login page
    exit();
}
