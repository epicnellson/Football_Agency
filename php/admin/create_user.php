<?php
// php/admin/create_user.php
include '../includes/admin_check.php';
include '../dbConnect.php';
include '../models/UserModel.php';

$userModel = new UserModel($conn);
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    
    // Validate inputs
    if (empty($username) || empty($email) || empty($password)) {
        $message = "<div class='error'>Please fill in all required fields!</div>";
    } elseif ($userModel->usernameExists($username)) {
        $message = "<div class='error'>Username already exists!</div>";
    } elseif ($userModel->emailExists($email)) {
        $message = "<div class='error'>Email already exists!</div>";
    } else {
        // Create user
        if ($userModel->create($username, $email, $password, $role, $first_name, $last_name, $phone, $address)) {
            $message = "<div class='success'>User created successfully!</div>";
            // Clear form
            $_POST = array();
        } else {
            $message = "<div class='error'>Error creating user!</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User - Football Agent SL</title>
    <link rel="stylesheet" href="../../styles.css">
    <style>
        .admin-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }
        .user-form {
            background: #2a2a2a;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #00cc66;
            font-weight: bold;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #444;
            border-radius: 5px;
            background: #1a1a1a;
            color: white;
            font-size: 1rem;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            outline: none;
            border-color: #00cc66;
        }
        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 1rem;
            margin-right: 1rem;
        }
        .btn-primary {
            background-color: #00cc66;
            color: #000;
            font-weight: bold;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        .success {
            background: #d4edda;
            color: #155724;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            border: 1px solid #c3e6cb;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            border: 1px solid #f5c6cb;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <img src="../../images/logo.png" alt="Football Agent Sierra Leone" class="logo-img">
                <span class="logo-text">Create User</span>
            </div>
            <nav>
                <ul>
                    <li><a href="../../index.php">Home</a></li>
                    <li><a href="dashboard.php">Admin Dashboard</a></li>
                    <li><a href="users.php">Users</a></li>
                    <li><a href="create_user.php" class="active">Add</a></li>
                    <li><a href="../dashboard.php">User Dashboard</a></li>
                    <li><a href="../logout.php">Logout (<?php echo $_SESSION['username']; ?>)</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="admin-container">
            <h2 class="section-title">Create New User</h2>
            
            <?php echo $message; ?>
            
            <div class="user-form">
                <form method="POST" action="">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="username">Username *</label>
                            <input type="text" id="username" name="username" value="<?php echo $_POST['username'] ?? ''; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" value="<?php echo $_POST['email'] ?? ''; ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password *</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="first_name">First Name *</label>
                            <input type="text" id="first_name" name="first_name" value="<?php echo $_POST['first_name'] ?? ''; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="last_name">Last Name *</label>
                            <input type="text" id="last_name" name="last_name" value="<?php echo $_POST['last_name'] ?? ''; ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="role">Role *</label>
                            <select id="role" name="role" required>
                                <option value="">Select Role</option>
                                <option value="admin" <?php echo (($_POST['role'] ?? '') == 'admin') ? 'selected' : ''; ?>>Admin</option>
                                <option value="player" <?php echo (($_POST['role'] ?? '') == 'player') ? 'selected' : ''; ?>>Player</option>
                                <option value="agent" <?php echo (($_POST['role'] ?? '') == 'agent') ? 'selected' : ''; ?>>Agent</option>
                                <option value="club_manager" <?php echo (($_POST['role'] ?? '') == 'club_manager') ? 'selected' : ''; ?>>Club Manager</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="text" id="phone" name="phone" value="<?php echo $_POST['phone'] ?? ''; ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea id="address" name="address" rows="3"><?php echo $_POST['address'] ?? ''; ?></textarea>
                    </div>
                    
                    <div style="margin-top: 2rem;">
                        <button type="submit" class="btn btn-primary">Create User</button>
                        <a href="users.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
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