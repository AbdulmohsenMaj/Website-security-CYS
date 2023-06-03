<?php
include 'session.php';
include 'connection.php';

// Retrieve existing feedback from the database
$sql = "SELECT * FROM Feedback";
$result = $conn->query($sql);

$feedbacks = array();

if ($result->num_rows > 0) {
    // Store each feedback in an array
    while ($row = $result->fetch_assoc()) {
        $feedbacks[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Feedback</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
    <style>
        .feedback-container {
            max-height: 300px;
            overflow-y: auto;
        }

        .feedback {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h1 class="mt-4">Feedback</h1>

        <div class="feedback-container">
            <?php
            // Display existing feedbacks
            if (count($feedbacks) > 0) {
                foreach ($feedbacks as $feedback) {
                    echo '<div class="feedback">';

                    // The htmlspecialchars() function is used to convert special characters to their HTML entities, 
                    // which prevents them from being interpreted as code (preventing XSS attacks).
                    echo "<p><strong>Name:</strong> " . htmlspecialchars($feedback["name"]) . "</p>";
                    echo "<p><strong>Message:</strong> " . htmlspecialchars($feedback["message"]) . "</p>";
                    echo "<p><strong>Created At:</strong> " . htmlspecialchars($feedback["created_at"]) . "</p>";
                    if ($isAdmin) {
                        echo '<form action="delete_feedback.php" method="post">';
                        echo '<input type="hidden" name="feedback_id" value="' . htmlspecialchars($feedback["id"]) . '">';
                        echo '<button type="submit" class="btn btn-danger">Delete</button>';
                        echo '</form>';
                    }
                    echo '</div>';
                }
            } else {
                echo "<p>No feedbacks yet.</p>";
            }
            ?>
        </div>




        <h2 class="mt-4">Submit Feedback</h2>
        <form action="submit_feedback.php" method="post">
            <div class="mb-3 hidden">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : ''; ?>" readonly>
            </div>
            <div class="mb-3 hidden">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message:</label>
                <textarea class="form-control" id="message" name="message" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>