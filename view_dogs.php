<?php
session_start();
// if (!isset($_SESSION['admin_id'])) {
//     header('Location: user_login.php'); // Redirect to login if not logged in
//     exit;
// }

// Include database connection
include 'db_connect.php';

// Fetch dogs from the database
$query = "SELECT * FROM dogs";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Error: " . mysqli_error($conn);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Dogs</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-color: #e5d6d6; 
        }
        .container {
            margin-top: 30px; /* Top margin for container */
        }

        h2 {
            color: #333; /* Heading color */
            text-align: center; /* Center align heading */
            margin-bottom: 30px; /* Margin below heading */
        }

        .card {
            border: none; 
            border-radius: 15px; 
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); 
            transition: transform 0.2s; 
            height: 100%; 
        }

        .card:hover {
            transform: scale(1.05); 
        }

        .card-img-top {
            border-radius: 15px 15px 0 0; 
            height: 200px; 
            object-fit: cover; 
        }

        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between; 
            padding: 20px; 
        }

        .card-title {
            text-align: center; 
            margin-bottom: 15px; 
        }

        .btn-adopt {
            margin-top: auto; 
            background-color:#ff6347;
            color: white;
            border-radius: 25px; 
            padding: 10px 20px; 
            transition: background-color 0.3s; 
            width: fit-content; 
            align-self: center; 
        }

        .btn-adopt:hover {
            background-color: #ff6347; 
            color: white;
        }

        @media (max-width: 768px) {
            .card {
                margin-bottom: 20px; 
            }
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

    <div class="container">
        <h2>Dogs Available for Adoption</h2>
        <div class="row">
            <?php while ($dog = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="uploads/dogs/<?php echo htmlspecialchars($dog['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($dog['dog_name']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($dog['dog_name']); ?></h5>
                            <p class="card-text"><strong>Breed:</strong> <?php echo htmlspecialchars($dog['breed']); ?></p>
                            <p class="card-text"><strong>Age:</strong> <?php echo htmlspecialchars($dog['age']); ?> years</p>
                            <p class="card-text"><strong>Description:</strong> <?php echo htmlspecialchars($dog['description']); ?></p>
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <!-- If the user is logged in, allow them to go to the adopt page -->
                                <a href="adopt.php?dog_id=<?php echo $dog['id']; ?>" class="btn btn-primary">Adopt Now</a>
                                <?php else: ?>
                                <!-- If the user is not logged in, redirect to the login page -->
                                <a href="login.php" class="btn btn-adopt">Adopt now</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
