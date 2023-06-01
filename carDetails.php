<?php
include 'session.php';
include 'connection.php';

// Get the car ID from the URL
$carId = $_GET['id'];

// Retrieve car details from the database
$stmt = $conn->prepare("SELECT * FROM Cars WHERE id = ?");
$stmt->bind_param("i", $carId);

$stmt->execute();

$result = $stmt->get_result();
$car = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Car Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
    <style>
        .car-image {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container">
        <h1 class="mt-4">Car Details</h1>

        <?php if ($car) : ?>
            <div class="row mt-4">
                <div class="col-md-6">
                    <p><strong>Make:</strong> <?php echo htmlspecialchars($car["make"]); ?></p>
                    <p><strong>Model:</strong> <?php echo htmlspecialchars($car["model"]); ?></p>
                    <p><strong>Year:</strong> <?php echo htmlspecialchars($car["year"]); ?></p>
                    <p><strong>Mileage:</strong> <?php echo htmlspecialchars($car["mileage"]); ?></p>
                    <p><strong>Color:</strong> <?php echo htmlspecialchars($car["color"]); ?></p>
                    <p><strong>Price:</strong> <?php echo htmlspecialchars($car["price"]); ?></p>
                    <p><strong>Status:</strong> <?php echo htmlspecialchars($car["status"]); ?></p>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($car["description"]); ?></p>
                </div>
                <div class="col-md-6">
                    <?php if ($car["image_data"]) : ?>
                        <img src="data:image/jpeg;base64, <?php echo base64_encode($car["image_data"]); ?>" alt="Car Image" class="car-image">
                    <?php endif; ?>
                </div>
            </div>
        <?php else : ?>
            <p>No car found with this ID.</p>
        <?php endif; ?>

        <a href="viewCars.php" class="btn btn-primary mt-4">Back</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>