<?php
session_start(); // Start session to access user information

include 'db_connect.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Adoption System</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Adoption System</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body>

    <!-- Navbar -->
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


    <!-- Banner Section -->
    <section class="banner">
        <div class="banner-content">
            <h1>Find your perfect companion today!</h1>
            <p>Adopt them!</p>
        </div>
    </section>


    <!-- About Us Section -->
    <section class="about-us">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-4">
                    <img src="images/doggy.jpg" alt="About Us" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <h2>About Us</h2>
                    <p>We are committed to finding loving homes for pets.</p>
                    <p>Our mission is to connect you with the perfect companion, while ensuring all animals are treated with care and love.</p>
                </div>
            </div>
        </div>
    </section>



    <!-- Featured Dogs Section -->
    <section class="featured-dogs mt-5">
        <div class="container">
            <h2 class="text-center">Featured Dogs for Adoption</h2>
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="dog-container text-center">
                        <img src="images/dog1.jpg" alt="Dog Name" class="img-fluid dog-img">
                        <p class="dog-name">Bujo</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="dog-container text-center">
                        <img src="images/dog2.jpg" alt="Dog Name" class="img-fluid dog-img">
                        <p class="dog-name">Kalu</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="dog-container text-center">
                        <img src="images/dog3.jpg" alt="Dog Name" class="img-fluid dog-img">
                        <p class="dog-name">Volu</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="dog-container text-center">
                        <img src="images/dog4.jpg" alt="Dog Name" class="img-fluid dog-img">
                        <p class="dog-name">Tuni</p>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Testimonials Section -->
    <section class="testimonials mt-5">
        <h2 class="text-center">What Our Adopters Say</h2>
        <div class="testimonials-content">
            <div class="testimonial">
                <p>"Adopting from here was a wonderful experience!"</p>
                <p> - John Doe</p>
            </div>
            <div class="testimonial">
                <p>"The team was so helpful and the process was seamless." </p>
                <p>- Jane Smith</p>
            </div>
            <div class="testimonial">
                <p>"We found our perfect companion, thanks to this amazing center." </p>
                <p> - Mary Johnson</p>
            </div>
            <div class="testimonial">
                <p>"Highly recommend adopting from here! They really care about the animals." </p>
                <p>- Alex Wilson</p>
            </div>
        </div>
    </section>


    <section class="donations mt-5">
        <div class="container text-center">
            <h2>Support Our Mission</h2>
            <p>Your generosity helps us provide care, shelter, and love to animals in need.</p>
            
            <!-- <h3>Why Your Donation Matters:</h3> -->
            <div class="row">
                <div class="col-md-6">
                    <div class="benefit">
                        <i class="fas fa-heart"></i>
                        <h4>💖 Rescue Operations</h4>
                        <p >Fund rescues of abandoned and abused animals.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="benefit">
                        <i class="fas fa-hospital-alt"></i>
                        <h4 >🏥 Veterinary Care</h4>
                        <p>Provide essential medical treatments and vaccinations.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="benefit">
                        <i class="fas fa-home"></i>
                        <h4 >🏠 Safe Shelter</h4>
                        <p>Maintain a loving environment for our animals.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="benefit">
                        <i class="fas fa-bowl-food"></i>
                        <h4>📦 Food & Supplies</h4>
                        <p>Ensure every pet has food and comfortable bedding.</p>
                    </div>
                </div>
                <div class="col-6 mx-auto">
                    <div class="benefit text-center">
                        <h4>Join Us in Making a Difference!</h4>
                        <p>By donating, you become a vital part of our family. Together, we can make a difference!</p>
                    </div>

                </div>
            </div>
            
            <a href="donate.php" class="btn btn-primary btn-lg">Donate Now</a>
        </div>
    </section>

    <section class="contact-us mt-5">
        <div class="container">
            <h2 class="text-center">Contact Us</h2>
            <p class="text-center">We would love to hear from you! Please fill out the form below:</p>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form action="contact_process.php" method="post">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email :</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message :</label>
                            <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary ">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <footer class="bg-dark text-white ">
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
                <div id="map" style="width: 100%; height: 120px;">
                    <!-- Replace this with an actual embedded map -->
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.180665618135!2d-122.41941508468043!3d37.77492977975965!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808581c1427d0b29%3A0xf9c1da3e8b1c36d2!2sSan%20Francisco%2C%20CA%2094102%2C%20USA!5e0!3m2!1sen!2sin!4v1625742189931!5m2!1sen!2sin"
                        width="100%" height="120" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
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

<!-- Font Awesome for social media icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">




    <script>
        let currentTestimonial = 0;
        const testimonials = document.querySelectorAll('.testimonial');
        const totalTestimonials = testimonials.length;

        document.querySelector('.next-arrow').addEventListener('click', () => {
            testimonials[currentTestimonial].classList.remove('active');
            currentTestimonial = (currentTestimonial + 1) % totalTestimonials;
            testimonials[currentTestimonial].classList.add('active');
        });

        document.querySelector('.prev-arrow').addEventListener('click', () => {
            testimonials[currentTestimonial].classList.remove('active');
            currentTestimonial = (currentTestimonial - 1 + totalTestimonials) % totalTestimonials;
            testimonials[currentTestimonial].classList.add('active');
        });

    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
