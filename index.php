<?php
session_start(); // Start the session

// Check if a session already exists
if (isset($_SESSION["username"])) {
    header("Location: welcome.php"); // Redirect to welcome.php
    exit();
}

if (isset($_GET['error'])) {
    if ($_GET['error'] == 1) {
        echo '<p style="color: red;">Password or username are incorrect.</p>';
    } else if ($_GET['error'] == 2) {
        echo '<p style="color: red;">Username and password must be filled out.</p>';
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <script src="validate.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Login</h1>
        <form action="login.php" method="post" onsubmit="return validateForm()">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" id="username" name="username" class="form-control">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            <button onclick="location.href='signupPage.php'" type="button" class="btn btn-secondary">Sign Up</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>