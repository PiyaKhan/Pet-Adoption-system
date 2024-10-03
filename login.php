<?php
session_start();
include 'db_connect.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute query
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($user_id, $username, $hashed_password);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        // Verify the password
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id; // Set session variable
            $_SESSION['username'] = $username; // Set session variable
            header('Location: index.php'); // Redirect to index page
            exit;
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No user found with that email.";
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">

    <style>
    body {
        background-color: #f0f2f5; /* Light background color */
    }

    .login-container {
        max-width: 400px; /* Limit container width */
        margin: 100px auto; /* Center vertically and horizontally */
        background-color: #ffffff; /* White background for the form */
        padding: 30px; /* Add padding around the form */
        border-radius: 8px; /* Rounded corners */
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    }

    h2 {
        text-align: center; /* Center the heading */
        color: #333; /* Darker color for the heading */
        margin-bottom: 20px; /* Space below the heading */
    }

    .form-group {
        margin-bottom: 15px; /* Spacing between form groups */
    }

    label {
        font-weight: bold; /* Bold labels for better visibility */
        color: #555; /* Medium gray color for labels */
    }

    .form-control {
        border: 1px solid #ced4da; /* Light gray border */
        border-radius: 5px; /* Rounded borders */
        padding: 10px; /* Padding inside inputs */
        transition: border-color 0.3s; /* Transition for border color */
    }

    .form-control:focus {
        border-color: #007bff; /* Blue border on focus */
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Subtle blue shadow on focus */
    }

    .btn-primary {
        width: 100%; /* Full width for the button */
        padding: 10px; /* Add padding for the button */
        border-radius: 5px; /* Rounded button */
        font-size: 16px; /* Larger font for button */
        transition: background-color 0.3s; /* Transition for background color */
    }

    .btn-primary:hover {
        background-color: #0056b3; /* Darken button color on hover */
        cursor: pointer; /* Change cursor to pointer */
    }

    p {
        text-align: center; /* Center the paragraph */
        color: #666; /* Lighter gray color for text */
    }

    a {
        color: #007bff; /* Link color */
        text-decoration: none; /* Remove underline */
    }

    a:hover {
        text-decoration: underline; /* Underline on hover */
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

    <div class="login-container mt-5">
        <h2>Login</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="login.php">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <p class="mt-3">Don't have an account? <a href="register.php">Register here</a>.</p>
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
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


