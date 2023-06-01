<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="welcome.php">Welcome</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="viewCars.php">View Cars for Sale</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="feedback.php">Feedback</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>
                <?php
                // Check if user is admin, display admin console button
                if ($_SESSION["isAdmin"]) {
                    echo '<li class="nav-item">
                                  <a class="nav-link" href="admin_console.php">Admin Console</a>
                              </li>';
                }
                ?>
            </ul>
            <form class="d-flex ms-auto" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <button class="btn btn-primary" type="submit" name="logout">Logout</button>
            </form>
        </div>
    </div>
</nav>