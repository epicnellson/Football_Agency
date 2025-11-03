<?php
// php/admin/edit_player.php
include '../includes/admin_check.php';
include '../dbConnect.php';
include '../models/UserModel.php';
include '../models/PlayerModel.php';

$userModel = new UserModel($conn);
$playerModel = new PlayerModel($conn);
$message = '';

// Get player ID from URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: players.php');
    exit();
}

$player_id = $_GET['id'];
$player = $playerModel->readOne($player_id);

if (!$player) {
    header('Location: players.php');
    exit();
}

// Get available agents
$agents = $playerModel->getAvailableAgents();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date_of_birth = $_POST['date_of_birth'];
    $position = $_POST['position'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $preferred_foot = $_POST['preferred_foot'];
    $current_club = trim($_POST['current_club']);
    $agent_id = $_POST['agent_id'] ?: NULL;
    $video_url = trim($_POST['video_url']);
    
    // Create stats array
    $stats = array(
        'goals' => $_POST['goals'] ?: 0,
        'assists' => $_POST['assists'] ?: 0,
        'matches' => $_POST['matches'] ?: 0,
        'yellow_cards' => $_POST['yellow_cards'] ?: 0,
        'red_cards' => $_POST['red_cards'] ?: 0
    );
    $stats_json = json_encode($stats);
    
    if ($playerModel->update($player_id, $date_of_birth, $position, $height, $weight, $preferred_foot, $current_club, $agent_id, $video_url, $stats_json)) {
        $message = "<div class='success'>Player profile updated successfully!</div>";
        // Refresh player data
        $player = $playerModel->readOne($player_id);
    } else {
        $message = "<div class='error'>Error updating player profile!</div>";
    }
}

// Decode stats if they exist
$stats = array();
if ($player['stats']) {
    $stats = json_decode($player['stats'], true);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Player - Football Agent SL</title>
    <link rel="stylesheet" href="../../styles.css">
    <style>
        .admin-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem;
        }
        .player-form {
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
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }
        .player-info-header {
            background: #1a1a1a;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
        }
        @media (max-width: 768px) {
            .form-row, .stats-grid {
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
                <span class="logo-text">Edit Player</span>
            </div>
            <nav>
                <ul>
                    <li><a href="../../index.php">Home</a></li>
                    <li><a href="dashboard.php">Admin Dashboard</a></li>
                    <li><a href="players.php">Player Management</a></li>
                    <li><a href="users.php">Users</a></li>
                    <li><a href="../dashboard.php">User Dashboard</a></li>
                    <li><a href="../logout.php">Logout (<?php echo $_SESSION['username']; ?>)</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="admin-container">
            <h2 class="section-title">Edit Player Profile</h2>
            
            <?php echo $message; ?>
            
            <div class="player-info-header">
                <p><strong>Editing:</strong> <?php echo $player['first_name'] . ' ' . $player['last_name']; ?></p>
                <p><strong>Username:</strong> <?php echo $player['username']; ?> | <strong>Email:</strong> <?php echo $player['email']; ?></p>
            </div>
            
            <div class="player-form">
                <form method="POST" action="">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="date_of_birth">Date of Birth</label>
                            <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo $player['date_of_birth']; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="position">Position *</label>
                            <select id="position" name="position" required>
                                <option value="Goalkeeper" <?php echo ($player['position'] == 'Goalkeeper') ? 'selected' : ''; ?>>Goalkeeper</option>
                                <option value="Defender" <?php echo ($player['position'] == 'Defender') ? 'selected' : ''; ?>>Defender</option>
                                <option value="Midfielder" <?php echo ($player['position'] == 'Midfielder') ? 'selected' : ''; ?>>Midfielder</option>
                                <option value="Forward" <?php echo ($player['position'] == 'Forward') ? 'selected' : ''; ?>>Forward</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="height">Height (cm)</label>
                            <input type="number" id="height" name="height" step="0.1" value="<?php echo $player['height']; ?>" placeholder="180.5">
                        </div>
                        
                        <div class="form-group">
                            <label for="weight">Weight (kg)</label>
                            <input type="number" id="weight" name="weight" step="0.1" value="<?php echo $player['weight']; ?>" placeholder="75.2">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="preferred_foot">Preferred Foot</label>
                            <select id="preferred_foot" name="preferred_foot">
                                <option value="Left" <?php echo ($player['preferred_foot'] == 'Left') ? 'selected' : ''; ?>>Left</option>
                                <option value="Right" <?php echo ($player['preferred_foot'] == 'Right') ? 'selected' : ''; ?>>Right</option>
                                <option value="Both" <?php echo ($player['preferred_foot'] == 'Both') ? 'selected' : ''; ?>>Both</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="current_club">Current Club</label>
                            <input type="text" id="current_club" name="current_club" value="<?php echo htmlspecialchars($player['current_club']); ?>" placeholder="FC Sierra Leone">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="agent_id">Assigned Agent</label>
                        <select id="agent_id" name="agent_id">
                            <option value="">No Agent</option>
                            <?php
                            if ($agents->num_rows > 0) {
                                while ($agent = $agents->fetch_assoc()) {
                                    $selected = ($player['agent_id'] == $agent['id']) ? 'selected' : '';
                                    echo "<option value='{$agent['id']}' {$selected}>{$agent['first_name']} {$agent['last_name']}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="video_url">Video URL (Highlights)</label>
                        <input type="url" id="video_url" name="video_url" value="<?php echo htmlspecialchars($player['video_url']); ?>" placeholder="https://youtube.com/...">
                    </div>
                    
                    <h4 style="color: #00cc66; margin-bottom: 1rem;">Player Statistics</h4>
                    <div class="stats-grid">
                        <div class="form-group">
                            <label for="goals">Goals</label>
                            <input type="number" id="goals" name="goals" value="<?php echo $stats['goals'] ?? 0; ?>" min="0">
                        </div>
                        <div class="form-group">
                            <label for="assists">Assists</label>
                            <input type="number" id="assists" name="assists" value="<?php echo $stats['assists'] ?? 0; ?>" min="0">
                        </div>
                        <div class="form-group">
                            <label for="matches">Matches Played</label>
                            <input type="number" id="matches" name="matches" value="<?php echo $stats['matches'] ?? 0; ?>" min="0">
                        </div>
                        <div class="form-group">
                            <label for="yellow_cards">Yellow Cards</label>
                            <input type="number" id="yellow_cards" name="yellow_cards" value="<?php echo $stats['yellow_cards'] ?? 0; ?>" min="0">
                        </div>
                        <div class="form-group">
                            <label for="red_cards">Red Cards</label>
                            <input type="number" id="red_cards" name="red_cards" value="<?php echo $stats['red_cards'] ?? 0; ?>" min="0">
                        </div>
                    </div>
                    
                    <div style="margin-top: 2rem;">
                        <button type="submit" class="btn btn-primary">Update Player Profile</button>
                        <a href="players.php" class="btn btn-secondary">Cancel</a>
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