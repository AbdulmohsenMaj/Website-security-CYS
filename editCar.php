<?php
include 'session.php';
include 'connection.php';

$carId = $_GET['id']; // Get the car id from the URL

// Fetch car data
$stmt = $conn->prepare("SELECT * FROM Cars WHERE id = ?");
$stmt->bind_param("i", $carId);
$stmt->execute();
$result = $stmt->get_result();
$car = $result->fetch_assoc();
$stmt->close();

// Edit car logic
if (isset($_POST['editCar'])) {
    $make = $_POST['make'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $mileage = $_POST['mileage'];
    $color = $_POST['color'];
    $price = $_POST['price'];
    $status = $_POST['status'];
    $description = $_POST['description'];

    // Handle the image upload
    if (isset($_FILES['image'])) {
        if ($_FILES['image']['error'] == 0) {
            // Check if the file is an image
            $check = getimagesize($_FILES['image']['tmp_name']);
            if ($check !== false) {
                $image_data = file_get_contents($_FILES['image']['tmp_name']);

                // Prepare and bind
                $stmt = $conn->prepare("UPDATE Cars SET make = ?, model = ?, year = ?, mileage = ?, color = ?, price = ?, status = ?, description = ?, image_data = ? WHERE id = ?");
                $stmt->bind_param("ssiisdsssi", $make, $model, $year, $mileage, $color, $price, $status, $description, $image_data, $carId);
            } else {
                echo "File is not an image.";
                exit();
            }
        } elseif ($_FILES['image']['error'] == 4) {
            // No file was uploaded. Keep the existing image.

            // Prepare and bind
            $stmt = $conn->prepare("UPDATE Cars SET make = ?, model = ?, year = ?, mileage = ?, color = ?, price = ?, status = ?, description = ? WHERE id = ?");
            $stmt->bind_param("ssiisdssi", $make, $model, $year, $mileage, $color, $price, $status, $description, $carId);
        } else {
            // An error occurred. You can handle this case as you see fit.
            echo "An error occurred while uploading the file.";
            exit();
        }
    } else {
        // No image was uploaded
        // Prepare and bind
        $stmt = $conn->prepare("UPDATE Cars SET make = ?, model = ?, year = ?, mileage = ?, color = ?, price = ?, status = ?, description = ? WHERE id = ?");
        $stmt->bind_param("ssiisdssi", $make, $model, $year, $mileage, $color, $price, $status, $description, $carId);
    }

    if ($stmt->execute()) {
        // Redirect back to the previous page
        header("Location: " . $_POST['referrer']);
        exit();
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Car</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-4">
        <h1>Edit Car</h1>

        <!-- HTML form for editing car data -->
        <form action="editCar.php?id=<?php echo $carId; ?>" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="make" class="form-label">Make:</label>
                <input type="text" id="make" name="make" class="form-control" value="<?php echo $car['make']; ?>">
            </div>
            <!-- Repeat for other fields... -->
            <div class="mb-3">
                <label for="model" class="form-label">Model:</label>
                <input type="text" id="model" name="model" class="form-control" value="<?php echo $car['model']; ?>">
            </div>
            <div class="mb-3">
                <label for="year" class="form-label">Year:</label>
                <input type="number" id="year" name="year" class="form-control" value="<?php echo $car['year']; ?>">
            </div>
            <div class="mb-3">
                <label for="mileage" class="form-label">Mileage:</label>
                <input type="number" id="mileage" name="mileage" class="form-control" value="<?php echo $car['mileage']; ?>">
            </div>
            <div class="mb-3">
                <label for="color" class="form-label">Color:</label>
                <input type="text" id="color" name="color" class="form-control" value="<?php echo $car['color']; ?>">
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price:</label>
                <input type="number" id="price" name="price" class="form-control" value="<?php echo $car['price']; ?>">
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status:</label>
                <select id="status" name="status" class="form-select">
                    <option value="FOR SALE" <?php if ($car['status'] == 'FOR SALE') echo 'selected'; ?>>FOR SALE
                    </option>
                    <option value="SOLD" <?php if ($car['status'] == 'SOLD') echo 'selected'; ?>>SOLD</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea id="description" name="description" class="form-control"><?php echo $car['description']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image:</label>
                <input type="file" id="image" name="image" class="form-control">
            </div>

            <!-- Hidden input to store the previous page URL -->
            <input type="hidden" name="referrer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>">
            <button type="submit" class="btn btn-primary" name="editCar">Edit Car</button>
        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>