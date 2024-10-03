<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php'); // Redirect if not logged in as admin
    exit;
}
require 'db_connect.php'; // Include your database connection file

// Fetch adoption requests
$sql = "
    SELECT users.username, users.email, 
           adoptions.phone, 
           dogs.dog_name AS dog_name, dogs.image AS dog_image, 
           adoptions.created_at AS adoption_date
    FROM adoptions
    JOIN users ON adoptions.user_id = users.id
    JOIN dogs ON adoptions.dog_id = dogs.id
";

$result = $conn->query($sql);
if (!$result) {
    echo "Error fetching adoption applications: " . $conn->error;
    exit; // Stop further execution if the query fails
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">

    <!-- Custom Styles -->
    <style>
        .dashboard-header {
            text-align: center;
            margin-top: 30px;
            font-family: 'Arial', sans-serif;
        }

        .manage-dogs-section {
            margin: 50px auto;
            text-align: center;
        }

        .manage-dogs-section .btn-primary {
            font-size: 18px;
            padding: 10px 20px;
            background-color: #28a745; /* Green shade */
            border: none;
            border-radius: 30px;
            transition: background-color 0.3s ease;
        }

        .manage-dogs-section .btn-primary:hover {
            background-color: #218838; /* Slightly darker green on hover */
        }

        .manage-dogs-section h3 {
            margin-bottom: 30px;
            font-size: 24px;
            color: #333;
        }

        .table-container {
            margin-top: 50px;
        }

        table.table {
            font-size: 16px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Dog image styling */
        td img {
            border-radius: 10px;
            object-fit: cover;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .manage-dogs-section .btn-primary {
                width: 100%;
                margin-top: 20px;
            }

            .table-responsive {
                font-size: 14px;
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
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="view_dogs.php">Adopt</a></li>
                <li class="nav-item"><a class="nav-link" href="donate.php">Donate</a></li>
                <li class="nav-item"><a class="nav-link" href="testimonials.php">Testimonials</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_login.php">Admin</a></li>

                <!-- Check if either admin or user is logged in -->
                <?php if (isset($_SESSION['admin_id'])): ?>
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
        <!-- Manage Dogs Section -->
        <div class="manage-dogs-section">
            <h3>Manage Dogs for Adoption</h3>
            <a href="add_dog.php" class="btn btn-primary">Add Dog for Adoption</a>
        </div>

        <!-- View Adoptions Section -->
        <div class="container table-container">
            <h2>Adoption Applications</h2>

            <?php if ($result->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered mt-3">
                        <thead class="thead-dark">
                            <tr>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Dog Name</th>
                                <th>Dog Image</th>
                                <th>Adoption Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                    <td><?php echo htmlspecialchars($row['dog_name']); ?></td>
                                    <td>
                                        <?php if (!empty($row['dog_image'])): ?>
                                            <img src="<?php echo htmlspecialchars($row['dog_image']); ?>" alt="Dog Image" width="100" onerror="this.onerror=null; this.src='path/to/default-image.jpg';">
                                        <?php else: ?>
                                            No Image Available
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['adoption_date']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p>No adoption applications found.</p>
            <?php endif; ?>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
