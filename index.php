<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Football Agent Sierra Leone - Home</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <img src="images/logo.png" alt="Football Agent Sierra Leone" class="logo-img">
                <span class="logo-text">Nelson Football Agent SL</span>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php" class="active">Home</a></li>
                    <li><a href="services.php">About</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li><a href="php/dashboard.php">Dashboard</a></li>
                        <li><a href="php/logout.php">Logout </a></li>
                    <?php else: ?>
                        <li><a href="php/login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-background">
                <img src="images/img1.jpg" alt="Football Stadium" class="hero-bg-img">
                <div class="hero-overlay"></div>
            </div>
            <div class="hero-content">
                <h2 class="hero-title">Leading Football Agency in Sierra Leone</h2>
                <p class="hero-subtitle">Connecting talented players with opportunities worldwide</p>
                <a href="contact.php" class="cta-button">  <!-- Fixed: changed contact.html to contact.php -->
                    <span>Get Started</span>
                    <div class="button-shine"></div>
                </a>
            </div>
        </section>

        <!-- Featured Players Section -->
        <section class="featured-players">
            <div class="container">
                <h3 class="section-title">Featured Players</h3>
                <div class="players-grid">
                    <div class="player-card">
                        <div class="player-image">
                            <img src="images/p2.jpg" alt="Player 1">
                        </div>
                        <h4>Musa Tombo</h4>
                        <p>Striker • 19 Years</p>
                    </div>
                    <div class="player-card">
                        <div class="player-image">
                            <img src="images/p1.jpg" alt="Player 2">
                        </div>
                        <h4>Kai Kamara</h4>
                        <p>Midfielder • 22 Years</p>
                    </div>
                    <div class="player-card">
                        <div class="player-image">
                           <img src="images/p3.jpg" alt="Player 3">
                        </div>
                        <h4>Ibrahim Sesay</h4>
                        <p>Goalkeeper • 26 Years</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section class="services">
            <div class="container">
                <h3 class="section-title">Our Services</h3>
                <div class="services-grid">
                    <div class="service-card">
                        <h4>Player Representation</h4>
                        <p>Comprehensive career management and professional representation</p>
                    </div>
                    <div class="service-card">
                        <h4>Contract Negotiations</h4>
                        <p>Expert negotiation for the best deals and opportunities</p>
                    </div>
                    <div class="service-card">
                        <h4>Career Development</h4>
                        <p>Guidance and support for player growth and advancement</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="testimonials">
            <div class="container">
                <h3 class="section-title">What Our Players Say</h3>
                <div class="testimonial">
                    <p>"Nelson Football Agent SL helped me achieve my dream of playing professionally. Their support and guidance were invaluable throughout my career development."</p>
                    <cite>Ahmed Kamara</cite>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="contact-info">
                    <h4>Contact Information</h4>
                    <p><a href="mailto:nelson@footballagent.sl">📧nelson@footballagent.sl</a></p>
                    <p><a href="tel:+23279826564">📞 +232 79 826-564</a></p>
                    <p><a href="https://www.google.com/maps/search/?api=1&query=Goderich+Street+Freetown+Sierra+Leone" target="_blank" rel="noopener">
                        📍15 Goderich Street,<br>Freetown, Sierra Leone</a>
                    </p>
                </div>
                <div class="social-links">
                    <h4>Follow Us</h4>
                    <a href="#" aria-label="Facebook">Facebook</a>
                    <a href="#" aria-label="Twitter">Twitter</a>
                    <a href="#" aria-label="Instagram">Instagram</a>
                    <a href="#" aria-label="LinkedIn">LinkedIn</a>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2025 Football Agent Sierra Leone. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>