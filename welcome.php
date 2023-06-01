<?php
// Start session
include 'session.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Welcome</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
</head>

<body>
    <?php
    // Include navbar.php after starting the session
    include 'navbar.php';
    ?>
    <div class="container mt-4">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h1>
        <p>This is your welcome page.</p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>