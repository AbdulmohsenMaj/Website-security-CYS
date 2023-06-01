<?php
include 'session.php';
include 'connection.php';

// Delete car logic
// Check if deleteCar is set
if (isset($_POST['deleteCar'])) {
    $carIdToDelete = $_POST['carIdToDelete']; // Get the id of the car to delete

    // Prepare a SQL statement to delete the car from the database
    $stmt = $conn->prepare("DELETE FROM Cars WHERE id = ?");
    // Prepare a SQL statement to delete the car from the database 
    $stmt->bind_param("i", $carIdToDelete);

    $stmt->execute();
    $stmt->close();
}

// Update car logic
// Check if updateCar is set
if (isset($_POST['updateCar'])) {
    // Get the details of the car to update
    $carIdToUpdate = $_POST['carIdToUpdate'];
    $make = $_POST['make'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $mileage = $_POST['mileage'];
    $color = $_POST['color'];
    $price = $_POST['price'];
    $status = $_POST['status'];
    $description = $_POST['description'];

    // Prepare a SQL statement to update the car in the database

    $stmt = $conn->prepare("UPDATE Cars SET make = ?, model = ?, year = ?, mileage = ?, color = ?, price = ?, status = ?, description = ? WHERE id = ?");

    $stmt->bind_param("ssiisdssi", $make, $model, $year, $mileage, $color, $price, $status, $description, $carIdToUpdate);
    // Bind the parameters to the SQL query
    // "ssiisdssi" is a format string, each character represents the type of the corresponding bind variable:
    // "s" means string,
    // "i" means integer,
    // "d" means double (floating point number),
    // "b" means blob and will be sent in packets.
    $stmt->execute();

    $stmt->close();
}

// Delete user logic
// Check if deleteUser is set
if (isset($_POST['deleteUser'])) {
    $userToDelete = $_POST['usernameToDelete']; // Get the username of the user to delete

    // Prepare a SQL statement to delete the user from the database
    $stmt = $conn->prepare("DELETE FROM Users WHERE username = ?");
    $stmt->bind_param("s", $userToDelete);

    $stmt->execute();

    $stmt->close();
}

// Add car logic
// Check if addCar is set
if (isset($_POST['addCar']) && isset($_FILES['image'])) {

    // Get the details of the car to add
    $make = $_POST['make'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $mileage = $_POST['mileage'];
    $color = $_POST['color'];
    $price = $_POST['price'];
    $status = $_POST['status'];
    $description = $_POST['description'];
    $date_posted = date('Y-m-d H:i:s'); // Get the current date and time

    // Handle the image upload
    // $_FILES is a superglobal variable in PHP which is used to upload files.
    // 'image' is the name attribute of the file input field in the HTML form.
    $image = $_FILES['image']; // Get the image file

    // file_get_contents() reads a file into a string. 
    // This is useful to store the content of a file in a variable.
    $image_data = file_get_contents($image['tmp_name']); // Get the image data

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO Cars (make, model, year, mileage, color, price, status, description, image_data, date_posted) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiisdssss", $make, $model, $year, $mileage, $color, $price, $status, $description, $image_data, $date_posted);

    $stmt->execute();

    $stmt->close();
}

// Retrieve all users from the database
$sql = "SELECT username FROM Users";
$result = $conn->query($sql);

$users = array();
//
if ($result->num_rows > 0) { // Check if there are any users in the database
    // Store each user in an array
    while ($row = $result->fetch_assoc()) { // Fetch a result row as an associative array
        $users[] = $row["username"]; // Append the username to the array
    }
}

// Retrieve all cars from the database
$sql = "SELECT * FROM Cars";
$result = $conn->query($sql);

$cars = array();

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) { // Fetch a result row as an associative array
        $cars[] = $row; // Append the car to the array
    }
}


$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
</head>

<body>
    <?php include 'navbar.php'; ?>


    <div class="container mt-4">
        <h1 class="mb-4">Admin Page</h1>
        <!-- add car form -->

        <h2 class="mt-4">Add Car</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="make" class="form-label">Make:</label>
                <input type="text" class="form-control" id="make" name="make" required>
            </div>
            <div class="mb-3">
                <label for="model" class="form-label">Model:</label>
                <input type="text" class="form-control" id="model" name="model" required>
            </div>
            <div class="mb-3">
                <label for="year" class="form-label">Year:</label>
                <input type="number" class="form-control" id="year" name="year" required>
            </div>
            <div class="mb-3">
                <label for="mileage" class="form-label">Mileage:</label>
                <input type="number" class="form-control" id="mileage" name="mileage" required>
            </div>
            <div class="mb-3">
                <label for="color" class="form-label">Color:</label>
                <input type="text" class="form-control" id="color" name="color" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price:</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status:</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="FOR SALE">FOR SALE</option>
                    <option value="SOLD">SOLD</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image:</label>
                <input type="file" class="form-control" id="image" name="image" required>
            </div>
            <button type="submit" class="btn btn-primary" name="addCar">Add Car</button>
        </form>
        <!-- all users display -->
        <h2 class="mt-4">All Users</h2>
        <div class="list-group mb-4">
            <?php
            foreach ($users as $user) {
                echo '<a href="#" class="list-group-item list-group-item-action">' . htmlspecialchars($user) . '</a>';
                echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
                echo '<input type="hidden" name="usernameToDelete" value="' . htmlspecialchars($user) . '">';
                echo '<button type="submit" class="btn btn-danger" name="deleteUser">Delete User</button>';
                echo '</form>';
            }
            ?>
        </div>
        <!-- all cars display  -->
        <h2>All Cars</h2>
        <div class="list-group mb-4">
            <?php
            foreach ($cars as $car) {
                echo '<a href="carDetails.php?id=' . $car["id"] . '" class="list-group-item list-group-item-action">' . "Make: " . $car["make"] . " - Model: " . $car["model"] . '</a>';
                // Rest of the car details...
                echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
                echo '<input type="hidden" name="carIdToDelete" value="' . $car["id"] . '">';
                echo '<button type="submit" class="btn btn-danger" name="deleteCar">Delete Car</button>';
                //edit car
                echo '<a href="editCar.php?id=' . $car["id"] . '" class="btn btn-primary">Edit Car</a>';
                echo '</form>';
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>


</body>

</html>