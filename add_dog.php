<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php'); // Redirect to login if not logged in
    exit;
}

// Include database connection
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $dog_name = $_POST['dog_name'];
    $breed = $_POST['breed'];
    $age = $_POST['age'];
    $description = $_POST['description'];

    // Handle image upload
    if (isset($_FILES['dog_image']) && $_FILES['dog_image']['error'] == 0) {
        $upload_dir = 'uploads/dogs/';
        $image_name = $_FILES['dog_image']['name'];
        $image_tmp_name = $_FILES['dog_image']['tmp_name'];
        $upload_path = $upload_dir . basename($image_name);

        // Check if directory exists and create it if it doesn't
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Move the uploaded file to the server
        if (move_uploaded_file($image_tmp_name, $upload_path)) {
            // Insert data into the database
            $query = "INSERT INTO dogs (dog_name, breed, age, description, image) VALUES ('$dog_name', '$breed', '$age', '$description', '$image_name')";
            if (mysqli_query($conn, $query)) {
                header('Location: admin_dashboard.php'); // Redirect after adding
                exit;
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo "Failed to upload image.";
        }
    } else {
        echo "No image uploaded or there was an upload error.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Dog</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="index.php">
            <img src="images/logo3.png" alt="Pet Adoption Center Logo" style="width: 200px; height: auto; margin-left: 20px;">
        </a>         
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="view_dogs.php">Adopt</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="donate.php">Donate</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="testimonials.php">Testimonials</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin_login.php">Admin</a>
                </li>

                <!-- Check if either admin or user is logged in -->
                <?php if (isset($_SESSION['admin_id'])): ?>
                    <!-- Admin Profile Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="images/user.png" alt="Admin Icon" style="width: 20px; height: 20px;">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="admin_dashboard.php">Admin Dashboard</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="logout.php">Logout</a>
                        </div>
                    </li>
                <?php elseif (isset($_SESSION['user_id'])): ?>
                    <!-- User Profile Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="images/user.png" alt="User Icon" style="width: 20px; height: 20px;">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="profile.php">Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="logout.php">Logout</a>
                        </div>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>  

    <div class="container mt-5">
        <form action="add_dog.php" method="POST" enctype="multipart/form-data">
            <h2>Add Dog for Adoption</h2>
            <div class="form-group">
                <input type="text" name="dog_name" class="form-control" placeholder="Dog Name" required>
            </div>
            <div class="form-group">
                <input type="text" name="breed" class="form-control" placeholder="Breed" required>
            </div>
            <div class="form-group">
                <input type="number" name="age" class="form-control" placeholder="Age (in years)" required>
            </div>
            <div class="form-group">
                <textarea name="description" class="form-control" placeholder="Description" required></textarea>
            </div>
            <div class="form-group">
                <input type="file" name="dog_image" class="form-control" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Dog</button>
        </form>
    </div>

    
</body>
</html>
