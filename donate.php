<?php
session_start();
require 'db_connect.php'; // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate to Help Dogs Find Their Forever Homes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-color: #f5f5f5;
        }
        .donation-banner {
            background-image: url('images/donations.jpg'); /* Add a suitable image */
            background-size: cover;
            background-position: center;
            color: #fff;
            /* text-align: center; */
            padding: 100px 0;
            height:80vh;
        }
        .donation-content {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            
        }
        .donation-title {
            color: #ff6347; /* A vibrant color for the title */
            font-weight: bold;
        }
        .item-list {
            list-style-type: none;
            padding: 0;
        }
        .item-list li {
            background: #f0f0f0;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
        }
        .btn-donate {
            background-color: #ff6347;
            color: #fff;
            font-weight: bold;
            width: 100%;
            border-radius: 25px;
            transition: background-color 0.3s;
        }
        .btn-donate:hover {
            background-color: #ff4500; /* Darker shade for hover */
        }
        .ad-section img, .ad-section video {
            width: 100%;
            border-radius: 8px;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="index.php">Pet Adoption Center</a>
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
    <div class="donation-banner">
        <h1 style="margin-left:25px">Help Us Give Dogs a Second Chance!</h1>
        <!-- <p style="margin-left:25px">Your donations make a difference in the lives of our furry friends.</p> -->
    </div>

    <div class="donation-content">
        <h2 class="donation-title">Why Donate?</h2>
        <p>Your generous contributions allow us to provide shelter, food, and medical care to dogs in need. Every little bit helps us continue our mission of finding these wonderful animals a loving home.</p>
    </div>

    <div class="container">
        <!-- First Advertisement Section -->
        <div class="row align-items-center my-4 ad-section">
            <div class="col-md-6">
                <h3 class="donation-title">Your Donations Provide Hope</h3>
                <p>Every donation helps us rescue and rehabilitate dogs. Your support allows us to provide essential care and find loving homes for these furry friends.</p>
            </div>
            <div class="col-md-6">
                <img src="images/donations2.jpg" alt="Dog Adoption" class="img-fluid">
            </div>
        </div>

        <!-- Second Advertisement Section -->
        <div class="row align-items-center my-4 ad-section">
            <div class="col-md-6">
                <img src="images/donations3.webp" alt="Support Our Mission" class="img-fluid">
            </div>
            <div class="col-md-6">
                <h3 class="donation-title">Support Our Mission</h3>
                <p>Join us in our mission to save lives. Your contributions directly impact the well-being of dogs in our care.</p>
            </div>
        </div>

        <!-- Third Advertisement Section -->
        <div class="row align-items-center my-4 ad-section">
            <div class="col-md-6">
                <h3 class="donation-title">Help Us Spread the Word!</h3>
                <p>Sharing our cause is just as important as donating. Help us reach more people by spreading the word about our mission.</p>
            </div>
            <div class="col-md-6">
                <video controls class="img-fluid">
                    <source src="images/donation-video.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>

    <div class="donation-content">
        <h3>What Do We Need?</h3>
        <ul class="item-list">
            <li>Dog Food (dry and wet)</li>
            <li>Collars and Leashes</li>
            <li>Toys and Treats</li>
            <li>Bedding and Blankets</li>
            <li>Cleaning Supplies</li>
            <li>Medical Supplies (bandages, medications)</li>
        </ul>

        <h3>Ready to Make a Difference?</h3>
        <p>If you would like to donate items or funds, please fill out the form below.</p>

        <div class="donation-content">
            <form id="donationForm">
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
                    <label for="donation_type">Type of Donation</label>
                    <select class="form-control" id="donation_type" name="donation_type" required>
                        <option value="">Select One</option>
                        <option value="Food">Dog Food</option>
                        <option value="Supplies">Supplies</option>
                        <option value="Monetary">Monetary Contribution</option>
                    </select>
                </div>

                <!-- Amount Field (only for monetary donations) -->
                <div class="form-group" id="amountField" style="display:none;">
                    <label for="amount">Donation Amount (in USD)</label>
                    <input type="number" class="form-control" id="amount" name="amount" min="1" placeholder="Enter amount">
                </div>

                <div class="form-group">
                    <label for="message">Additional Message (optional)</label>
                    <textarea class="form-control" id="message" name="message" rows="4"></textarea>
                </div>
                <button type="submit" class="btn btn-donate">Submit Donation</button>
            </form>
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

    <script>
        // Show/Hide amount field based on donation type selection
        document.getElementById('donation_type').addEventListener('change', function() {
            const amountField = document.getElementById('amountField');
            if (this.value === 'Monetary') {
                amountField.style.display = 'block';
                document.getElementById('amount').required = true;
            } else {
                amountField.style.display = 'none';
                document.getElementById('amount').required = false;
            }
        });

        // Handle form submission with SweetAlert for confirmation
        document.getElementById('donationForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission behavior

            // Get form values
            const name = document.getElementById('name').value;
            const donationType = document.getElementById('donation_type').value;

            // Display success message using SweetAlert
            Swal.fire({
                title: 'Thank You, ' + name + '!',
                text: 'Your ' + donationType + ' donation has been submitted successfully.',
                icon: 'success',
                confirmButtonText: 'Great!'
            });

            // Optionally reset the form after submission
            document.getElementById('donationForm').reset();
            document.getElementById('amountField').style.display = 'none'; // Hide the amount field
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>