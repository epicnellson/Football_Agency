<?php
// php/admin/dashboard.php
include  '../includes/admin_check.php';
include '../dbConnect.php';
include '../models/UserModel.php';

$userModel = new UserModel($conn);

// Get user counts by role
$adminCount = $userModel->getUsersByRole('admin')->num_rows;
$playerCount = $userModel->getUsersByRole('player')->num_rows;
$agentCount = $userModel->getUsersByRole('agent')->num_rows;
$clubManagerCount = $userModel->getUsersByRole('club_manager')->num_rows;
$totalUsers = $userModel->readAll()->num_rows;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Football Agent SL</title>
    <link rel="stylesheet" href="../../styles.css">
    <style>
        .admin-container {
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
            margin: 2rem 0;
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
            font-size: 2.5rem;
            color: #00cc66;
            font-weight: bold;
        }
        .stat-label {
            color: #ccc;
            margin-top: 0.5rem;
            font-size: 1.1rem;
        }
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin: 2rem 0;
        }
        .action-card {
            background: #2a2a2a;
            padding: 1.5rem;
            border-radius: 10px;
            text-align: center;
            border: 1px solid #333;
            transition: all 0.3s ease;
            text-decoration: none;
            color: white;
        }
        .action-card:hover {
            transform: translateY(-3px);
            border-color: #00cc66;
            background: #333;
        }
        .action-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <img src="../../images/logo.png" alt="Football Agent Sierra Leone" class="logo-img">
                <span class="logo-text">Admin Panel</span>
            </div>
            <nav>
                <ul>
                    <li><a href="../../index.php">Home</a></li>
                    <li><a href="../../services.php">About</a></li>
                    <li><a href="../../contact.php">Contact</a></li>
                    <li><a href="dashboard.php" class="active">Admin</a></li>
                    <li><a href="../dashboard.php">Dashboard</a></li>
                    <li><a href="../profile.php">Profile</a></li>
                    <li><a href="../logout.php">Logout (<?php echo $_SESSION['username']; ?>)</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="admin-container">
            <div class="welcome-card">
                <h2>Admin Dashboard 🛠️</h2>
                <p>Welcome, <strong><?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name']; ?></strong></p>
                <p>You have full system access to manage users and content.</p>
            </div>

            <h3 class="section-title">System Overview</h3>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number"><?php echo $totalUsers; ?></div>
                    <div class="stat-label">Total Users</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $adminCount; ?></div>
                    <div class="stat-label">Admins</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $playerCount; ?></div>
                    <div class="stat-label">Players</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $agentCount; ?></div>
                    <div class="stat-label">Agents</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $clubManagerCount; ?></div>
                    <div class="stat-label">Club Managers</div>
                </div>
            </div>

            <h3 class="section-title">Quick Actions</h3>
            <div class="quick-actions">
                <a href="users.php" class="action-card">
                    <div class="action-icon">👥</div>
                    <h4>Manage Users</h4>
                    <p>View, edit, and delete users</p>
                </a>
                <a href="create_user.php" class="action-card">
                    <div class="action-icon">➕</div>
                    <h4>Add New User</h4>
                    <p>Create new user accounts</p>
                </a>
                <a href="players.php" class="action-card">
                    <div class="action-icon">⚽</div>
                    <h4>Player Management</h4>
                    <p>Manage player profiles</p>
                </a>
                <a href="../dashboard.php" class="action-card">
                    <div class="action-icon">📊</div>
                    <h4>User Dashboard</h4>
                    <p>Return to main dashboard</p>
                </a>
            </div>

            <div style="background: #2a2a2a; padding: 1.5rem; border-radius: 10px; margin-top: 2rem;">
                <h4>Recent Activity</h4>
                <p>Last login: <?php echo date('F j, Y, g:i a'); ?></p>
                <p>System status: <span style="color: #00cc66;">●</span> Operational</p>
            </div>
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