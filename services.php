<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About & Services - Football Agent Sierra Leone</title>
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
                    <li><a href="index.php">Home</a></li>
                    <li><a href="services.php" class="active">About</a></li>
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
        <!-- About Section -->
        <section class="about-compact">
            <div class="container">
                <h2><b>About</b> Nelson Football Agent Sierra Leone</h2>
                <p class="about-compact-text">We are Sierra Leone's premier football agency, dedicated to representing and developing talented players. With a strong global network and years of expertise, we connect local talent to international opportunities.</p>
                <div class="about-compact-stats">
                    <div class="about-stat">
                        <div class="stat-number">50+</div>
                        <div class="stat-label">Players Represented</div>
                    </div>
                    <div class="about-stat">
                        <div class="stat-number">15+</div>
                        <div class="stat-label">Countries Reached</div>
                    </div>
                    <div class="about-stat">
                        <div class="stat-number">100%</div>
                        <div class="stat-label">Client Commitment</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why Choose Us Section -->
        <section class="why-choose-us">
            <div class="container">
                <div class="why-choose-wrapper">
                    <div class="why-choose-image">
                        <img src="images/img2.jpg" alt="Why Choose Football Agent SL" class="why-choose-img">
                    </div>
                    <div class="why-choose-content">
                        <h2>Why Choose Us</h2>
                        <p class="why-choose-intro">We stand out as Sierra Leone's leading football agency through our proven track record and personalized approach to player development.</p>
                        
                        <div class="why-choose-points">
                            <div class="point">
                                <h4>Proven Success</h4>
                                <p>We've successfully placed players in professional leagues across 15+ countries with tangible career advancements.</p>
                            </div>
                            <div class="point">
                                <h4>Global Network</h4>
                                <p>Access to international clubs and scouts through our established worldwide connections in the football industry.</p>
                            </div>
                            <div class="point">
                                <h4>Personalized Approach</h4>
                                <p>Every player receives customized career planning and dedicated support tailored to their unique goals and potential.</p>
                            </div>
                            <div class="point">
                                <h4>Local Expertise</h4>
                                <p>Deep understanding of Sierra Leonean talent combined with international market knowledge for optimal placement.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Services -->
        <section class="services">
            <div class="container">
                <h3 class="section-title">What We Offer</h3>
                <div class="services-detailed">
                    <div class="service-item">
                        <h4>Player Representation</h4>
                        <p>Complete career management and professional representation for football players at all levels.</p>
                        <ul>
                            <li>Talent scouting and assessment</li>
                            <li>Career guidance and planning</li>
                            <li>Image management and branding</li>
                        </ul>
                    </div>
                    
                    <div class="service-item">
                        <h4>Contract Negotiations</h4>
                        <p>Expert negotiation services to secure the best possible deals for our clients.</p>
                        <ul>
                            <li>Salary and bonus negotiations</li>
                            <li>Transfer fee discussions</li>
                            <li>Contract terms and conditions</li>
                        </ul>
                    </div>
                    
                    <div class="service-item">
                        <h4>Career Development</h4>
                        <p>Comprehensive support for player growth and career advancement.</p>
                        <ul>
                            <li>Training program recommendations</li>
                            <li>Skill assessment and analysis</li>
                            <li>Performance tracking and improvement</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Additional Services -->
        <section class="additional-services">
            <div class="container">
                <h3 class="section-title">Additional Services</h3>
                <div class="additional-grid">
                    <div class="additional-item">
                        <h4>Performance Analytics</h4>
                        <p>Detailed analysis of player performance using advanced metrics and data visualization.</p>
                    </div>
                    
                    <div class="additional-item">
                        <h4>Educational Support</h4>
                        <p>Guidance on academic pursuits alongside football career development.</p>
                    </div>
                    
                    <div class="additional-item">
                        <h4>Financial Planning</h4>
                        <p>Advice on financial management and investment opportunities for professional players.</p>
                    </div>
                    
                    <div class="additional-item">
                        <h4>International Transfers</h4>
                        <p>Expertise in facilitating international transfers and work permit processes.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Process Section -->
        <section class="process-section">
            <div class="container">
                <h3 class="section-title">Our Process</h3>
                <div class="process-steps">
                    <div class="step">
                        <div class="step-number">1</div>
                        <h4>Initial Consultation</h4>
                        <p>We meet with you to understand your goals, current situation, and aspirations.</p>
                    </div>
                    
                    <div class="step">
                        <div class="step-number">2</div>
                        <h4>Assessment & Planning</h4>
                        <p>Comprehensive evaluation of your skills and development of a personalized career plan.</p>
                    </div>
                    
                    <div class="step">
                        <div class="step-number">3</div>
                        <h4>Implementation</h4>
                        <p>We work together to execute the plan, providing ongoing support and guidance.</p>
                    </div>
                    
                    <div class="step">
                        <div class="step-number">4</div>
                        <h4>Monitoring & Adjustment</h4>
                        <p>Regular reviews and adjustments to ensure continued progress toward your goals.</p>
                    </div>
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
                    <p> <a href="tel:+23279826564">📞 +232 79 826-564</a></p>
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