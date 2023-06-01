<?php

include 'session.php';
include 'limited_connection.php';

// Fetch the distinct makes and models from the database
$result = $conn->query("SELECT DISTINCT make FROM Cars");
$makes = $result->fetch_all(MYSQLI_ASSOC);

$result = $conn->query("SELECT DISTINCT model FROM Cars");
$models = $result->fetch_all(MYSQLI_ASSOC);

// Get the selected make and model from the request, if any
$selectedMake = isset($_POST['make']) ? $_POST['make'] : '';
$selectedModel = isset($_POST['model']) ? $_POST['model'] : '';

// Prepare and bind
$query = "SELECT * FROM Cars WHERE status = ?";
$params = array("s", &$status);

if ($selectedMake) {
    $query .= " AND make = ?";
    $params[0] .= "s";
    $params[] = &$selectedMake;
}

if ($selectedModel) {
    $query .= " AND model = ?";
    $params[0] .= "s";
    $params[] = &$selectedModel;
}

$stmt = $conn->prepare($query);
call_user_func_array(array($stmt, 'bind_param'), $params);

$status = "FOR SALE"; // We want to fetch cars that are for sale

$stmt->execute();

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>

<head>
    <title>View Cars</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-4">
        <h1>View Cars</h1>

        <!-- Search form -->
        <form method="post" action="viewCars.php" class="mb-4">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <select name="make" class="form-select">
                        <option value="">All Makes</option>
                        <?php foreach ($makes as $make) { ?>
                            <option value="<?php echo $make['make']; ?>" <?php if ($make['make'] == $selectedMake) echo 'selected'; ?>><?php echo $make['make']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <select name="model" class="form-select">
                        <option value="">All Models</option>
                        <?php foreach ($models as $model) { ?>
                            <option value="<?php echo $model['model']; ?>" <?php if ($model['model'] == $selectedModel) echo 'selected'; ?>><?php echo $model['model']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
        </form>

        <!-- Display cars -->
        <?php
        if ($result->num_rows > 0) {
            // Fetch the car data
            while ($row = $result->fetch_assoc()) {
                echo '<a href="carDetails.php?id=' . $row["id"] . '" class="d-block text-decoration-none mb-3">';
                echo '<div class="card">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">Make: ' . $row["make"] . '</h5>';
                echo '<p class="card-text">Model: ' . $row["model"] . '</p>';
                echo '<p class="card-text">Price: ' . $row["price"] . '</p>';
                echo '<p class="card-text">Year: ' . $row["year"] . '</p>';
                echo '<img src="data:image/jpeg;base64,' . base64_encode($row["image_data"]) . '" class="img-fluid" alt="Car Image">';
                echo '</div>';
                echo '</div>';
                echo '</a>';
            }
        } else {
            echo "<p>No cars for sale</p>";
        }
        ?>

    </div>

    <!-- Back button -->
    <div class="container mt-4">
        <a href="welcome.php" class="btn btn-secondary">Back</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>