<?php
// php/admin/players.php
include '../includes/admin_check.php';
include '../dbConnect.php';
include '../models/UserModel.php';
include '../models/PlayerModel.php';

$userModel = new UserModel($conn);
$playerModel = new PlayerModel($conn);
$message = '';

// Handle player deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    
    if ($playerModel->delete($delete_id)) {
        $message = "<div class='success'>Player profile deleted successfully!</div>";
    } else {
        $message = "<div class='error'>Error deleting player profile!</div>";
    }
}

// Get all players with user details
$players = $playerModel->readAllWithUsers();

// Get available agents for the dropdown
$agents = $playerModel->getAvailableAgents();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player Management - Football Agent SL</title>
    <link rel="stylesheet" href="../../styles.css">
    <style>
        .admin-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }
        .player-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
            background: #2a2a2a;
            border-radius: 10px;
            overflow: hidden;
        }
        .player-table th, .player-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #333;
        }
        .player-table th {
            background-color: #1a1a1a;
            color: #00cc66;
            font-weight: bold;
        }
        .player-table tr:hover {
            background-color: #333;
        }
        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin: 0.25rem;
            font-size: 0.9rem;
        }
        .btn-primary {
            background-color: #00cc66;
            color: #000;
        }
        .btn-danger {
            background-color: #dc3545;
            color: white;
        }
        .btn-edit {
            background-color: #ffc107;
            color: #000;
        }
        .btn-info {
            background-color: #17a2b8;
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
        .position-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: bold;
        }
        .position-goalkeeper { background: #dc3545; color: white; }
        .position-defender { background: #007bff; color: white; }
        .position-midfielder { background: #28a745; color: white; }
        .position-forward { background: #ffc107; color: #000; }
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 0.5rem;
            margin-top: 0.5rem;
        }
        .stat-item {
            background: #1a1a1a;
            padding: 0.25rem 0.5rem;
            border-radius: 3px;
            font-size: 0.8rem;
            text-align: center;
        }
        .player-card {
            background: #2a2a2a;
            border: 1px solid #333;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }
        .player-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 1rem;
        }
        .player-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }
        .info-item {
            margin-bottom: 0.5rem;
        }
        .info-label {
            color: #00cc66;
            font-weight: bold;
            display: block;
        }
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #666;
        }
        .empty-state-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .view-toggle {
            margin-bottom: 1rem;
        }
        .view-toggle button {
            padding: 0.5rem 1rem;
            background: #333;
            border: 1px solid #444;
            color: white;
            cursor: pointer;
        }
        .view-toggle button.active {
            background: #00cc66;
            color: #000;
        }
        .btn-info {
            background-color: #17a2b8;
            color: white;
        }
    </style>
    <script>
        function toggleView(viewType) {
            const tableView = document.getElementById('tableView');
            const cardView = document.getElementById('cardView');
            const tableBtn = document.getElementById('tableBtn');
            const cardBtn = document.getElementById('cardBtn');
            
            if (viewType === 'table') {
                tableView.style.display = 'block';
                cardView.style.display = 'none';
                tableBtn.classList.add('active');
                cardBtn.classList.remove('active');
            } else {
                tableView.style.display = 'none';
                cardView.style.display = 'block';
                tableBtn.classList.remove('active');
                cardBtn.classList.add('active');
            }
        }
    </script>
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <img src="../../images/logo.png" alt="Football Agent Sierra Leone" class="logo-img">
                <span class="logo-text"> Player Management</span>
            </div>
            <nav>
                <ul>
                    <li><a href="../../index.php">Home</a></li>
                    <li><a href="dashboard.php">Admin Dashboard</a></li>
                    <li><a href="users.php">Users</a></li>
                    <li><a href="players.php" class="active">Player Management</a></li>
                    <li><a href="create_user.php">Add</a></li>
                    <li><a href="../dashboard.php">User Dashboard</a></li>
                    <li><a href="../logout.php">Logout (<?php echo $_SESSION['username']; ?>)</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="admin-container">
            <h2 class="section-title">Player Management ⚽</h2>
            
            <?php echo $message; ?>
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h3>Player Profiles (<?php echo $players->num_rows; ?>)</h3>
    </div>
    <div style="display: flex; gap: 1rem; align-items: center;">
        <div class="view-toggle">
            <button id="tableBtn" class="active" onclick="toggleView('table')">Table View</button>
            <button id="cardBtn" onclick="toggleView('card')">Card View</button>
        </div>
        <!-- ADD THIS BUTTON -->
        <a href="create_player_profile.php" class="btn btn-primary">➕ Add Player Profile</a>
    </div>
</div>

            <!-- Table View -->
            <div id="tableView">
                <table class="player-table">
                    <thead>
                        <tr>
                            <th>Player</th>
                            <th>Position</th>
                            <th>Club</th>
                            <th>Age</th>
                            <th>Height/Weight</th>
                            <th>Agent</th>
                            <th>Stats</th>
                            <th>Video</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if ($players->num_rows > 0) {
                            while ($player = $players->fetch_assoc()) {
                                $positionClass = 'position-' . strtolower($player['position']);
                                $age = $player['date_of_birth'] ? floor((time() - strtotime($player['date_of_birth'])) / 31556926) : 'N/A';
                                $height = $player['height'] ? $player['height'] . ' cm' : 'N/A';
                                $weight = $player['weight'] ? $player['weight'] . ' kg' : 'N/A';
                                $stats = $player['stats'] ? json_decode($player['stats'], true) : [];
                                
                                // Get agent name if exists
                                $agentName = 'No Agent';
                                if ($player['agent_id']) {
                                    $agent = $userModel->readOne($player['agent_id']);
                                    $agentName = $agent ? $agent['first_name'] . ' ' . $agent['last_name'] : 'Unknown Agent';
                                }
                                
                                echo "<tr>";
                                echo "<td>";
                                echo "<strong>{$player['first_name']} {$player['last_name']}</strong><br>";
                                echo "<small style='color: #ccc;'>{$player['email']}</small>";
                                echo "</td>";
                                echo "<td><span class='position-badge {$positionClass}'>{$player['position']}</span></td>";
                                echo "<td>{$player['current_club']}</td>";
                                echo "<td>{$age}</td>";
                                echo "<td>{$height}<br>{$weight}</td>";
                                echo "<td>{$agentName}</td>";
                                
                                echo "<td>";
                                if ($stats) {
                                    echo "<div class='stats-grid'>";
                                    // Display specific stats with clear labels
                                    if (isset($stats['goals'])) {
                                        echo "<div class='stat-item' title='Goals'>⚽ {$stats['goals']}</div>";
                                    }
                                    if (isset($stats['assists'])) {
                                        echo "<div class='stat-item' title='Assists'>🎯 {$stats['assists']}</div>";
                                    }
                                    if (isset($stats['matches'])) {
                                        echo "<div class='stat-item' title='Matches'>👟 {$stats['matches']}</div>";
                                    }
                                    if (isset($stats['yellow_cards'])) {
                                        echo "<div class='stat-item' title='Yellow Cards'>🟡 {$stats['yellow_cards']}</div>";
                                    }
                                    if (isset($stats['red_cards'])) {
                                        echo "<div class='stat-item' title='Red Cards'>🔴 {$stats['red_cards']}</div>";
                                    }
                                    echo "</div>";
                                } else {
                                    echo "No stats";
                                }
                                echo "</td>";
                                echo "<td>";
                                if (!empty($player['video_url'])) {
                                    echo "<a href='{$player['video_url']}' target='_blank' class='btn btn-info' style='font-size: 0.8rem; padding: 0.25rem 0.5rem;'>Watch</a>";
                                } else {
                                    echo "No video";
                                }
                                echo "</td>";

                                echo "<td class='action-buttons'>";
                                echo "<a href='edit_player.php?id={$player['id']}' class='btn btn-edit'>Edit</a>";
                                echo "<a href='players.php?delete_id={$player['id']}' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this player profile?\")'>Delete</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8' style='text-align: center; padding: 2rem;'>No player profiles found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Card View -->
            <div id="cardView" style="display: none;">
                <?php 
                if ($players->num_rows > 0) {
                    $players->data_seek(0); // Reset pointer
                    while ($player = $players->fetch_assoc()) {
                        $positionClass = 'position-' . strtolower($player['position']);
                        $age = $player['date_of_birth'] ? floor((time() - strtotime($player['date_of_birth'])) / 31556926) : 'N/A';
                        $height = $player['height'] ? $player['height'] . ' cm' : 'N/A';
                        $weight = $player['weight'] ? $player['weight'] . ' kg' : 'N/A';
                        $stats = $player['stats'] ? json_decode($player['stats'], true) : ['goal'];
                        
                        // Get agent name if exists
                        $agentName = 'No Agent';
                        if ($player['agent_id']) {
                            $agent = $userModel->readOne($player['agent_id']);
                            $agentName = $agent ? $agent['first_name'] . ' ' . $agent['last_name'] : 'Unknown Agent';
                        }
                        
                        echo "<div class='player-card'>";
                        echo "<div class='player-header'>";
                        echo "<div>";
                        echo "<h4>{$player['first_name']} {$player['last_name']}</h4>";
                        echo "<p style='color: #ccc; margin: 0;'>{$player['email']} • {$player['phone']}</p>";
                        echo "</div>";
                        echo "<div class='action-buttons'>";
                        echo "<a href='edit_player.php?id={$player['id']}' class='btn btn-edit'>Edit</a>";
                        echo "<a href='players.php?delete_id={$player['id']}' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this player profile?\")'>Delete</a>";
                        echo "</div>";
                        echo "</div>";
                        
                        echo "<div class='player-info'>";
                        echo "<div class='info-item'><span class='info-label'>Position:</span> <span class='position-badge {$positionClass}'>{$player['position']}</span></div>";
                        echo "<div class='info-item'><span class='info-label'>Club:</span> {$player['current_club']}</div>";
                        echo "<div class='info-item'><span class='info-label'>Age:</span> {$age}</div>";
                        echo "<div class='info-item'><span class='info-label'>Height/Weight:</span> {$height} / {$weight}</div>";
                        echo "<div class='info-item'><span class='info-label'>Preferred Foot:</span> {$player['preferred_foot']}</div>";
                        echo "<div class='info-item'><span class='info-label'>Agent:</span> {$agentName}</div>";
                        echo "</div>";

                        echo "<div class='info-item'><span class='info-label'>Video:</span> ";
                        if (!empty($player['video_url'])) {
                            echo "<a href='{$player['video_url']}' target='_blank' class='btn btn-info' style='font-size: 0.8rem; padding: 0.25rem 0.5rem;'>Watch Highlights</a>";
                        } else {
                            echo "No video";
                        }
                        echo "</div>";
                        echo "</div>";
                        
                        if ($stats) {
                            echo "<div style='margin-top: 1rem;'>";
                            echo "<span class='info-label'>Statistics:</span>";
                            echo "<div class='stats-grid'>";
                            // Display specific stats with clear labels and icons
                            if (isset($stats['goals'])) {
                                echo "<div class='stat-item' title='Goals'>⚽ Goals: {$stats['goals']}</div>";
                            }
                            if (isset($stats['assists'])) {
                                echo "<div class='stat-item' title='Assists'>🎯 Assists: {$stats['assists']}</div>";
                            }
                            if (isset($stats['matches'])) {
                                echo "<div class='stat-item' title='Matches'>👟 Matches: {$stats['matches']}</div>";
                            }
                            if (isset($stats['yellow_cards'])) {
                                echo "<div class='stat-item' title='Yellow Cards'>🟡 Yellows: {$stats['yellow_cards']}</div>";
                            }
                            if (isset($stats['red_cards'])) {
                                echo "<div class='stat-item' title='Red Cards'>🔴 Reds: {$stats['red_cards']}</div>";
                            }
                            echo "</div>";
                            echo "</div>";
                        }
                        
                        echo "</div>";
                    }
                } else {
                    echo "<div class='empty-state'>";
                    echo "<div class='empty-state-icon'>⚽</div>";
                    echo "<h3>No Player Profiles</h3>";
                    echo "<p>No player profiles have been created yet.</p>";
                    echo "<a href='create_user.php?role=player' class='btn btn-primary'>Create First Player</a>";
                    echo "</div>";
                }
                ?>
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

    <script>
        // Initialize table view as default
        toggleView('table');
    </script>
</body>
</html>
<?php $conn->close(); ?>