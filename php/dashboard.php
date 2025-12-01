<?php
// php/dashboard.php
include 'includes/auth_check.php';
include 'dbConnect.php';
include 'models/UserModel.php';

$userModel = new UserModel($conn);
$currentUser = $userModel->readOne($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Football Agent SL</title>
    <link rel="stylesheet" href="../styles.css">
    <style>
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        .welcome-card {
            background: #2a2a2a;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            border-left: 4px solid #00cc66;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }
        .stat-card {
            background: #2a2a2a;
            padding: 1.5rem;
            border-radius: 10px;
            text-align: center;
            border: 1px solid #333;
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            border-color: #00cc66;
        }
        .stat-number {
            font-size: 2rem;
            color: #00cc66;
            font-weight: bold;
        }
        .stat-label {
            color: #ccc;
            margin-top: 0.5rem;
        }
        .user-info {
            background: #2a2a2a;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 2rem;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }
        .info-item {
            padding: 0.5rem 0;
            border-bottom: 1px solid #333;
        }
        .info-label {
            color: #00cc66;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <img src="../images/logo.png" alt="Football Agent Sierra Leone" class="logo-img">
                <span class="logo-text">Dashboard</span>
            </div>
            <nav>
                <ul>
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="../services.php">About</a></li>
                    <li><a href="../contact.php">Contact</a></li>
                    <li><a href="dashboard.php" class="active">Dashboard</a></li>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="logout.php">Logout </a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="dashboard-container">
            <div class="welcome-card">
                <h2>Welcome, <?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name']; ?>! 👋</h2>
                <p>Role: <strong style="color: #00cc66;"><?php echo ucfirst($_SESSION['user_role']); ?></strong></p>
                <p>Last login: <?php echo date('F j, Y, g:i a'); ?></p>
            </div>

            <div class="user-info">
                <h3>Your Profile Information</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Username:</span> <?php echo $currentUser['username']; ?>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email:</span> <?php echo $currentUser['email']; ?>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Phone:</span> <?php echo $currentUser['phone'] ?: 'Not set'; ?>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Address:</span> <?php echo $currentUser['address'] ?: 'Not set'; ?>
                    </div>
                </div>
            </div>

            <h3 class="section-title">Dashboard Overview</h3>
            <div class="stats-grid">
                <?php if($_SESSION['user_role'] == 'player'): ?>
                    <div class="stat-card">
                        <div class="stat-number">25</div>
                        <div class="stat-label">Goals Scored</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">12</div>
                        <div class="stat-label">Assists</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">40</div>
                        <div class="stat-label">Matches Played</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">1</div>
                        <div class="stat-label">Current Agent</div>
                    </div>

                <?php elseif($_SESSION['user_role'] == 'agent'): ?>
                    <div class="stat-card">
                        <div class="stat-number">15</div>
                        <div class="stat-label">Players Represented</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">5</div>
                        <div class="stat-label">Years Experience</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">10+</div>
                        <div class="stat-label">Successful Transfers</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">3</div>
                        <div class="stat-label">Active Contracts</div>
                    </div>

                <?php elseif($_SESSION['user_role'] == 'club_manager'): ?>
                    <div class="stat-card">
                        <div class="stat-number">25</div>
                        <div class="stat-label">Team Players</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">3</div>
                        <div class="stat-label">Trophies Won</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">85%</div>
                        <div class="stat-label">Win Rate</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">5</div>
                        <div class="stat-label">Scouts</div>
                    </div>

                <?php else: ?>
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $userModel->readAll()->num_rows; ?></div>
                        <div class="stat-label">Total Users</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">4</div>
                        <div class="stat-label">User Roles</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">100%</div>
                        <div class="stat-label">System Uptime</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Support</div>
                    </div>
                <?php endif; ?>
            </div>

            <?php if($_SESSION['user_role'] == 'admin'): ?>
                <div style="text-align: center; margin-top: 2rem;">
                    <a href="admin/dashboard.php" style="background: #00cc66; color: #000; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold;">
                        Go to Admin Panel
                    </a>
                </div>
            <?php endif; ?>
        </div>
        
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
<?php $conn->close(); ?>