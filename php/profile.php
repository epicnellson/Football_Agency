<?php
// php/profile.php
include 'includes/auth_check.php';
include 'dbConnect.php';
include 'models/UserModel.php';
include 'models/PlayerModel.php';

$userModel = new UserModel($conn);
$playerModel = new PlayerModel($conn);
$message = '';

$currentUser = $userModel->readOne($_SESSION['user_id']);

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    
    if ($userModel->update($_SESSION['user_id'], $currentUser['username'], $currentUser['email'], $currentUser['role'], $first_name, $last_name, $phone, $address)) {
        $message = "<div class='success'>Profile updated successfully!</div>";
        // Update session
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;
        $currentUser = $userModel->readOne($_SESSION['user_id']);
    } else {
        $message = "<div class='error'>Error updating profile!</div>";
    }
}

// Get player profile if user is a player
$playerProfile = null;
if ($_SESSION['user_role'] == 'player') {
    $playerProfile = $playerModel->readByUserId($_SESSION['user_id']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Football Agent SL</title>
    <link rel="stylesheet" href="../styles.css">
    <style>
        .profile-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem;
        }
        .profile-card {
            background: #2a2a2a;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            border-left: 4px solid #00cc66;
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
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #444;
            border-radius: 5px;
            background: #1a1a1a;
            color: white;
        }
        .btn {
            padding: 0.75rem 1.5rem;
            background: #00cc66;
            color: #000;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }
        .info-item {
            padding: 1rem;
            background: #1a1a1a;
            border-radius: 5px;
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
                <span class="logo-text"> My Profile</span>
            </div>
            <nav>
                <ul>
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="profile.php" class="active">Profile</a></li>
                    <li><a href="logout.php">Logout (<?php echo $_SESSION['username']; ?>)</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="profile-container">
            <h2 class="section-title">My Profile</h2>
            
            <?php echo $message; ?>
            
            <div class="profile-card">
                <h3>Personal Information</h3>
                <form method="POST" action="">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="first_name" value="<?php echo $currentUser['first_name']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="last_name" value="<?php echo $currentUser['last_name']; ?>" required>
                        </div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" value="<?php echo $currentUser['username']; ?>" disabled>
                            <small style="color: #ccc;">Username cannot be changed</small>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" value="<?php echo $currentUser['email']; ?>" disabled>
                            <small style="color: #ccc;">Email cannot be changed</small>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" value="<?php echo $currentUser['phone']; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Address</label>
                        <textarea name="address" rows="3"><?php echo $currentUser['address']; ?></textarea>
                    </div>
                    
                    <button type="submit" class="btn">Update Profile</button>
                </form>
            </div>

            <?php if ($_SESSION['user_role'] == 'player' && $playerProfile): ?>
            <div class="profile-card">
                <h3>Player Information</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Position:</span> <?php echo $playerProfile['position'] ?: 'Not set'; ?>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Current Club:</span> <?php echo $playerProfile['current_club'] ?: 'Not set'; ?>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Height:</span> <?php echo $playerProfile['height'] ? $playerProfile['height'] . ' cm' : 'Not set'; ?>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Weight:</span> <?php echo $playerProfile['weight'] ? $playerProfile['weight'] . ' kg' : 'Not set'; ?>
                    </div>
                </div>
                <p style="margin-top: 1rem;">
                    <small>Player profile details can be updated by administrators.</small>
                </p>
            </div>
            <?php endif; ?>

            <div class="profile-card">
                <h3>Account Information</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Role:</span> <?php echo ucfirst($currentUser['role']); ?>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Member Since:</span> <?php echo date('F j, Y', strtotime($currentUser['created_at'])); ?>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Status:</span> 
                        <span style="color: #00cc66;"><?php echo $currentUser['is_active'] ? 'Active' : 'Inactive'; ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Last Updated:</span> <?php echo date('F j, Y g:i A', strtotime($currentUser['updated_at'])); ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>