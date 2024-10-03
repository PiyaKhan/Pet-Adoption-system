<?php
session_start();
require 'db_connect.php'; // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit;
}

// Get the dog ID from the URL
if (isset($_GET['dog_id'])) {
    $dog_id = $_GET['dog_id'];

    // Fetch dog details from the database
    $sql = "SELECT * FROM dogs WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $dog_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $dog = $result->fetch_assoc();
    } else {
        echo "No dog found with that ID.";
        exit;
    }

    // Handle adoption application submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user_id = $_SESSION['user_id']; // Get logged-in user ID
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $message = $_POST['message'];

        // Check if the user has already submitted an application for this dog
        $check_sql = "SELECT * FROM adoptions WHERE user_id = ? AND dog_id = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("ii", $user_id, $dog_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            // Show SweetAlert notification if application already exists
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@10'></script>";
            echo "<script>
                window.onload = function() {
                    Swal.fire({
                        title: 'Application Already Submitted!',
                        text: 'You have already submitted an application for adopting this dog.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'view_dogs.php'; // Redirect to view dogs page
                        }
                    });
                }
            </script>";
        } else {
            // Insert the adoption request into the 'adoptions' table
            $sql = "INSERT INTO adoptions (user_id, dog_id, name, email, phone, message) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iissss", $user_id, $dog_id, $name, $email, $phone, $message);

            if ($stmt->execute()) {
                // Show SweetAlert notification on success
                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@10'></script>";
                echo "<script>
                    window.onload = function() {
                        Swal.fire({
                            title: 'Application Submitted!',
                            text: 'We will contact you soon regarding the adoption.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'view_dogs.php'; // Redirect to view dogs page
                            }
                        });
                    }
                </script>";
            } else {
                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@10'></script>";
                echo "<script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was a problem submitting your application. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                </script>";
            }
            $stmt->close();
        }
        $check_stmt->close();
    }
} else {
    echo "No dog ID provided.";
    exit;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adopt a Dog - <?php echo htmlspecialchars($dog['name']); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f5f5f5;
        }
        .adopt-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .adopt-container h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .dog-details {
            margin-bottom: 30px;
            text-align: center;
        }
        .form-group label {
            font-weight: bold;
            color: #555;
        }
        .btn-submit {
            background-color: #ffc107;
            color: #fff;
            font-weight: bold;
            width: 100%;
            border-radius: 25px;
            transition: background-color 0.3s;
        }
        .btn-submit:hover {
            background-color: #e0a800;
        }
    </style>
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

    <div class="adopt-container">
        <h2>Adoption Application</h2>
        <div class="dog-details">
            <?php 
            // Check if image exists and construct the correct image path
            $image_path = 'images/' . htmlspecialchars($dog['image']); // Update with the correct path
            ?>
            <img src="<?php echo $image_path; ?>" alt="<?php echo htmlspecialchars($dog['dog_name']); ?>" class="img-fluid" style="max-width: 100%; height: auto;">
            <h3><?php echo htmlspecialchars($dog['dog_name']); ?></h3>
            <p><strong>Breed:</strong> <?php echo htmlspecialchars($dog['breed']); ?></p>
            <p><strong>Age:</strong> <?php echo htmlspecialchars($dog['age']); ?> years</p>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($dog['description']); ?></p>
        </div>
        
        <form action="adopt.php?dog_id=<?php echo $dog_id; ?>" method="POST">
            <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="message">Why do you want to adopt this dog?</label>
                <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-submit">Submit Application</button>
        </form>
    </div>
    <footer class="bg-dark text-white pt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="text-white">Home</a></li>
                        <li><a href="about.php" class="text-white">About Us</a></li>
                        <li><a href="view_dogs.php" class="text-white">Adopt</a></li>
                        <li><a href="donate.php" class="text-white">Donate</a></li>
                        <li><a href="testimonials.php" class="text-white">Testimonials</a></li>
                        <li><a href="admin_login.php" class="text-white">Admin</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact Us</h5>
                    <p>
                        123 Pet Adoption St,<br>
                        Animal City, AC 12345<br>
                        Phone: (123) 456-7890<br>
                        Email: info@petadoption.com
                    </p>
                </div>
                <div class="col-md-4">
                    <h5>Find Us</h5>
                    <div id="map" style="width: 100%; height: 150px;">
                        <!-- Replace this with an actual embedded map -->
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.180665618135!2d-122.41941508468043!3d37.77492977975965!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808581c1427d0b29%3A0xf9c1da3e8b1c36d2!2sSan%20Francisco%2C%20CA%2094102%2C%20USA!5e0!3m2!1sen!2sin!4v1625742189931!5m2!1sen!2sin"
                            width="100%" height="150" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col text-center">
                    <h5>Follow Us</h5>
                    <a href="#" class="text-white me-3"><i class="fab fa-facebook fa-2x"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-twitter fa-2x"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-2x"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-linkedin fa-2x"></i></a>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col text-center">
                    <p>&copy; 2024 Pet Adoption Center. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
