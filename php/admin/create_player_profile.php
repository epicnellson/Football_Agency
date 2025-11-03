<?php
// php/admin/create_player_profile.php
include '../includes/admin_check.php';
include '../dbConnect.php';
include '../models/UserModel.php';
include '../models/PlayerModel.php';

$userModel = new UserModel($conn);
$playerModel = new PlayerModel($conn);
$message = '';

// Get all player users
$playerUsers = $userModel->getUsersByRole('player');

// Get players who already have profiles
$playersWithProfiles = array();
$existingPlayers = $playerModel->readAllWithUsers();
while ($player = $existingPlayers->fetch_assoc()) {
    $playersWithProfiles[] = $player['user_id'];
}

// Get available agents
$agents = $playerModel->getAvailableAgents();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $date_of_birth = $_POST['date_of_birth'] ?? NULL;
    $position = $_POST['position'];
    $height = !empty($_POST['height']) ? $_POST['height'] : NULL;
    $weight = !empty($_POST['weight']) ? $_POST['weight'] : NULL;
    $preferred_foot = $_POST['preferred_foot'] ?? NULL;
    $current_club = !empty($_POST['current_club']) ? trim($_POST['current_club']) : NULL;
    $agent_id = !empty($_POST['agent_id']) ? $_POST['agent_id'] : NULL;
    $video_url = !empty($_POST['video_url']) ? trim($_POST['video_url']) : NULL;
    
    // Create stats array with null coalescing to prevent warnings
    $stats = array(
        'goals' => $_POST['goals'] ?? 0,
        'assists' => $_POST['assists'] ?? 0,
        'matches' => $_POST['matches'] ?? 0
    );
    $stats_json = json_encode($stats);
    
    // Check if player already has a profile
    $existingProfile = $playerModel->readByUserId($user_id);
    if ($existingProfile) {
        $message = "<div class='error'>This player already has a profile!</div>";
    } else {
        if ($playerModel->create($user_id, $date_of_birth, $position, $height, $weight, $preferred_foot, $current_club, $agent_id, $video_url, $stats_json)) {
            $message = "<div class='success'>Player profile created successfully!</div>";
            $_POST = array(); // Clear form
        } else {
            $message = "<div class='error'>Error creating player profile!</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Player Profile - Football Agent SL</title>
    <link rel="stylesheet" href="../../styles.css">
    <style>
        .admin-container { max-width: 1000px; margin: 0 auto; padding: 2rem; }
        .player-form { background: #2a2a2a; padding: 2rem; border-radius: 15px; margin-bottom: 2rem; }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; color: #00cc66; font-weight: bold; }
        .form-group input, .form-group select, .form-group textarea { 
            width: 100%; padding: 0.75rem; border: 1px solid #444; border-radius: 5px; 
            background: #1a1a1a; color: white; font-size: 1rem; 
        }
        .btn { padding: 0.75rem 1.5rem; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; margin-right: 1rem; }
        .btn-primary { background-color: #00cc66; color: #000; font-weight: bold; }
        .btn-secondary { background-color: #6c757d; color: white; }
        .success { background: #d4edda; color: #155724; padding: 1rem; border-radius: 5px; margin-bottom: 1rem; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 5px; margin-bottom: 1rem; border: 1px solid #f5c6cb; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem; margin-top: 1rem; }
        .info-box { background: #1a1a1a; padding: 1rem; border-radius: 5px; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <img src="../../images/logo.png" alt="Football Agent Sierra Leone" class="logo-img">
                <span class="logo-text">Create Player Profile</span>
            </div>
            <nav>
                <ul>
                    <li><a href="../../index.php">Home</a></li>
                    <li><a href="dashboard.php">Admin Dashboard</a></li>
                    <li><a href="players.php">Player Management</a></li>
                    <li><a href="users.php">Users</a></li>
                    <li><a href="create_player_profile.php" class="active">Add Player Profile</a></li>
                    <li><a href="../dashboard.php">User Dashboard</a></li>
                    <li><a href="../logout.php">Logout (<?php echo $_SESSION['username']; ?>)</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="admin-container">
            <h2 class="section-title">Create Player Profile</h2>
            
            <?php echo $message; ?>
            
            <div class="player-form">
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="user_id">Select Player *</label>
                        <select id="user_id" name="user_id" required>
                            <option value="">Choose a player...</option>
                            <?php
                            if ($playerUsers->num_rows > 0) {
                                while ($player = $playerUsers->fetch_assoc()) {
                                    // Skip players who already have profiles
                                    if (!in_array($player['id'], $playersWithProfiles)) {
                                        echo "<option value='{$player['id']}'>{$player['first_name']} {$player['last_name']} ({$player['username']})</option>";
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="date_of_birth">Date of Birth</label>
                            <input type="date" id="date_of_birth" name="date_of_birth">
                        </div>
                        <div class="form-group">
                            <label for="position">Position *</label>
                            <select id="position" name="position" required>
                                <option value="">Select Position</option>
                                <option value="Goalkeeper">Goalkeeper</option>
                                <option value="Defender">Defender</option>
                                <option value="Midfielder">Midfielder</option>
                                <option value="Forward">Forward</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="height">Height (cm)</label>
                            <input type="number" id="height" name="height" step="0.1" placeholder="180.5">
                        </div>
                        <div class="form-group">
                            <label for="weight">Weight (kg)</label>
                            <input type="number" id="weight" name="weight" step="0.1" placeholder="75.2">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="preferred_foot">Preferred Foot</label>
                            <select id="preferred_foot" name="preferred_foot">
                                <option value="">Select Preferred Foot</option>
                                <option value="Left">Left</option>
                                <option value="Right">Right</option>
                                <option value="Both">Both</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="current_club">Current Club</label>
                            <input type="text" id="current_club" name="current_club" placeholder="FC Sierra Leone">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="agent_id">Assign Agent</label>
                        <select id="agent_id" name="agent_id">
                            <option value="">No Agent</option>
                            <?php
                            if ($agents->num_rows > 0) {
                                while ($agent = $agents->fetch_assoc()) {
                                    echo "<option value='{$agent['id']}'>{$agent['first_name']} {$agent['last_name']}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="video_url">Video URL (Highlights)</label>
                        <input type="url" id="video_url" name="video_url" placeholder="https://youtube.com/...">
                    </div>
                    
                    <h4 style="color: #00cc66; margin-bottom: 1rem;">Player Statistics</h4>
                    <div class="stats-grid">
                        <div class="form-group">
                            <label for="goals">Goals</label>
                            <input type="number" id="goals" name="goals" value="0" min="0">
                        </div>
                        <div class="form-group">
                            <label for="assists">Assists</label>
                            <input type="number" id="assists" name="assists" value="0" min="0">
                        </div>
                        <div class="form-group">
                            <label for="matches">Matches Played</label>
                            <input type="number" id="matches" name="matches" value="0" min="0">
                        </div>
                    </div>
                    
                    <div style="margin-top: 2rem;">
                        <button type="submit" class="btn btn-primary">Create Player Profile</button>
                        <a href="players.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
<?php $conn->close(); ?>