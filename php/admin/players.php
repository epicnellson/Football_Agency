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
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
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
            font-size: 0.9rem;
            text-transform: uppercase;
        }
        
        .player-table tr:hover {
            background-color: #333;
            transition: background-color 0.3s ease;
        }
        
        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin: 0.25rem;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            font-weight: 600;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }
        
        .btn-primary {
            background-color: #00cc66;
            color: #000;
        }
        
        .btn-primary:hover {
            background-color: #00ff7f;
        }
        
        .btn-danger {
            background-color: #dc3545;
            color: white;
        }
        
        .btn-danger:hover {
            background-color: #c82333;
        }
        
        .btn-edit {
            background-color: #ffc107;
            color: #000;
        }
        
        .btn-edit:hover {
            background-color: #ffca28;
        }
        
        .btn-info {
            background-color: #17a2b8;
            color: white;
        }
        
        .btn-info:hover {
            background-color: #138496;
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
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: bold;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .position-goalkeeper { background: #dc3545; color: white; }
        .position-defender { background: #007bff; color: white; }
        .position-midfielder { background: #28a745; color: white; }
        .position-forward { background: #ffc107; color: #000; }
        
        .action-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }
        
        .stats-grid {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }
        
        .stat-item {
            background: #1a1a1a;
            padding: 0.35rem 0.6rem;
            border-radius: 5px;
            font-size: 0.75rem;
            text-align: center;
            border: 1px solid #333;
            white-space: nowrap;
        }
        
        .player-card {
            background: #2a2a2a;
            border: 1px solid #333;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .player-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 204, 102, 0.2);
        }
        
        .player-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #333;
        }
        
        .player-header h4 {
            color: #00cc66;
            font-size: 1.5rem;
            margin: 0 0 0.5rem 0;
        }
        
        .player-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-top: 1rem;
        }
        
        .info-item {
            background: #1a1a1a;
            padding: 1rem;
            border-radius: 8px;
            border-left: 3px solid #00cc66;
        }
        
        .info-label {
            color: #00cc66;
            font-weight: bold;
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .info-value {
            color: #fff;
            font-size: 1rem;
        }
        
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #666;
            background: #2a2a2a;
            border-radius: 15px;
            margin-top: 2rem;
        }
        
        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
        
        .view-toggle {
            display: flex;
            gap: 0;
            background: #1a1a1a;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #333;
        }
        
        .view-toggle button {
            padding: 0.6rem 1.2rem;
            background: transparent;
            border: none;
            color: #ccc;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .view-toggle button:hover {
            background: #333;
            color: #fff;
        }
        
        .view-toggle button.active {
            background: #00cc66;
            color: #000;
        }
        
        .header-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .header-controls h3 {
            margin: 0;
            color: #fff;
        }
        
        .controls-right {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        
        .player-name-cell {
            font-weight: bold;
            color: #fff;
            font-size: 1rem;
        }
        
        .player-email {
            color: #999;
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }
        
        .stats-section {
            margin-top: 1rem;
            padding: 1rem;
            background: #1a1a1a;
            border-radius: 8px;
        }
        
        @media (max-width: 768px) {
            .player-table {
                font-size: 0.85rem;
            }
            
            .player-table th, .player-table td {
                padding: 0.75rem 0.5rem;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .header-controls {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .controls-right {
                width: 100%;
                justify-content: space-between;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <img src="../../images/logo.png" alt="Football Agent Sierra Leone" class="logo-img">
                <span class="logo-text">Player Management</span>
            </div>
            <nav>
                <ul>
                    <li><a href="../../index.php">Home</a></li>
                    <li><a href="dashboard.php">Admin</a></li>
                    <li><a href="users.php">Users</a></li>
                    <li><a href="players.php" class="active">Players</a></li>
                    <li><a href="../logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="admin-container">
            <h2 class="section-title">⚽ Player Management</h2>
            
            <?php echo $message; ?>
            
            <div class="header-controls">
                <div>
                    <h3>Player Profiles (<?php echo $players->num_rows; ?>)</h3>
                </div>
                <div class="controls-right">
                    <div class="view-toggle">
                        <button id="tableBtn" class="active" onclick="toggleView('table')">📊 Table View</button>
                        <button id="cardBtn" onclick="toggleView('card')">🗂️ Card View</button>
                    </div>
                    <a href="create_player_profile.php" class="btn btn-primary">➕ Add Player</a>
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
                            <th>Physical</th>
                            <th>Agent</th>
                            <th>Statistics</th>
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
                                $height = $player['height'] ? $player['height'] . ' cm' : '-';
                                $weight = $player['weight'] ? $player['weight'] . ' kg' : '-';
                                $stats = $player['stats'] ? json_decode($player['stats'], true) : [];
                                
                                // Get agent name if exists
                                $agentName = 'No Agent';
                                if ($player['agent_id']) {
                                    $agent = $userModel->readOne($player['agent_id']);
                                    $agentName = $agent ? $agent['first_name'] . ' ' . $agent['last_name'] : 'Unknown';
                                }
                                
                                echo "<tr>";
                                
                                // Player Name & Email
                                echo "<td>";
                                echo "<div class='player-name-cell'>{$player['first_name']} {$player['last_name']}</div>";
                                echo "<div class='player-email'>{$player['email']}</div>";
                                echo "</td>";
                                
                                // Position
                                echo "<td><span class='position-badge {$positionClass}'>{$player['position']}</span></td>";
                                
                                // Club
                                echo "<td>" . ($player['current_club'] ?: 'Free Agent') . "</td>";
                                
                                // Age
                                echo "<td><strong>{$age}</strong> years</td>";
                                
                                // Physical Stats
                                echo "<td>";
                                echo "<div style='line-height: 1.6;'>";
                                echo "📏 {$height}<br>";
                                echo "⚖️ {$weight}";
                                echo "</div>";
                                echo "</td>";
                                
                                // Agent
                                echo "<td>{$agentName}</td>";
                                
                                // Statistics
                                echo "<td>";
                                if ($stats && count($stats) > 0) {
                                    echo "<div class='stats-grid'>";
                                    if (isset($stats['goals'])) {
                                        echo "<div class='stat-item'>⚽ {$stats['goals']}</div>";
                                    }
                                    if (isset($stats['assists'])) {
                                        echo "<div class='stat-item'>🎯 {$stats['assists']}</div>";
                                    }
                                    if (isset($stats['matches'])) {
                                        echo "<div class='stat-item'>🏃 {$stats['matches']}</div>";
                                    }
                                    echo "</div>";
                                } else {
                                    echo "<span style='color: #666;'>No stats</span>";
                                }
                                echo "</td>";
                                
                                // Video
                                echo "<td>";
                                if (!empty($player['video_url'])) {
                                    echo "<a href='{$player['video_url']}' target='_blank' class='btn btn-info' title='Watch highlights'>🎥 Watch</a>";
                                } else {
                                    echo "<span style='color: #666;'>No video</span>";
                                }
                                echo "</td>";

                                // Actions
                                echo "<td>";
                                echo "<div class='action-buttons'>";
                                echo "<a href='edit_player.php?id={$player['id']}' class='btn btn-edit' title='Edit player'>✏️ Edit</a>";
                                echo "<a href='players.php?delete_id={$player['id']}' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this player?\")' title='Delete player'>🗑️ Delete</a>";
                                echo "</div>";
                                echo "</td>";
                                
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='9' style='text-align: center; padding: 3rem; color: #666;'>No player profiles found</td></tr>";
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
                        $stats = $player['stats'] ? json_decode($player['stats'], true) : [];
                        
                        // Get agent name if exists
                        $agentName = 'No Agent';
                        if ($player['agent_id']) {
                            $agent = $userModel->readOne($player['agent_id']);
                            $agentName = $agent ? $agent['first_name'] . ' ' . $agent['last_name'] : 'Unknown Agent';
                        }
                        
                        echo "<div class='player-card'>";
                        
                        // Header
                        echo "<div class='player-header'>";
                        echo "<div>";
                        echo "<h4>⚽ {$player['first_name']} {$player['last_name']}</h4>";
                        echo "<p style='color: #999; margin: 0; font-size: 0.9rem;'>{$player['email']} • {$player['phone']}</p>";
                        echo "</div>";
                        echo "<div class='action-buttons'>";
                        echo "<a href='edit_player.php?id={$player['id']}' class='btn btn-edit'>✏️ Edit</a>";
                        echo "<a href='players.php?delete_id={$player['id']}' class='btn btn-danger' onclick='return confirm(\"Are you sure?\")'>🗑️ Delete</a>";
                        echo "</div>";
                        echo "</div>";
                        
                        // Player Info Grid
                        echo "<div class='player-info'>";
                        
                        echo "<div class='info-item'>";
                        echo "<span class='info-label'>Position</span>";
                        echo "<div class='info-value'><span class='position-badge {$positionClass}'>{$player['position']}</span></div>";
                        echo "</div>";
                        
                        echo "<div class='info-item'>";
                        echo "<span class='info-label'>Current Club</span>";
                        echo "<div class='info-value'>" . ($player['current_club'] ?: 'Free Agent') . "</div>";
                        echo "</div>";
                        
                        echo "<div class='info-item'>";
                        echo "<span class='info-label'>Age</span>";
                        echo "<div class='info-value'>{$age} years</div>";
                        echo "</div>";
                        
                        echo "<div class='info-item'>";
                        echo "<span class='info-label'>Height / Weight</span>";
                        echo "<div class='info-value'>{$height} / {$weight}</div>";
                        echo "</div>";
                        
                        echo "<div class='info-item'>";
                        echo "<span class='info-label'>Preferred Foot</span>";
                        echo "<div class='info-value'>{$player['preferred_foot']}</div>";
                        echo "</div>";
                        
                        echo "<div class='info-item'>";
                        echo "<span class='info-label'>Agent</span>";
                        echo "<div class='info-value'>{$agentName}</div>";
                        echo "</div>";
                        
                        echo "</div>";
                        
                        // Statistics Section
                        if ($stats && count($stats) > 0) {
                            echo "<div class='stats-section'>";
                            echo "<span class='info-label'>📊 Statistics</span>";
                            echo "<div class='stats-grid' style='margin-top: 0.75rem;'>";
                            if (isset($stats['goals'])) {
                                echo "<div class='stat-item'>⚽ Goals: <strong>{$stats['goals']}</strong></div>";
                            }
                            if (isset($stats['assists'])) {
                                echo "<div class='stat-item'>🎯 Assists: <strong>{$stats['assists']}</strong></div>";
                            }
                            if (isset($stats['matches'])) {
                                echo "<div class='stat-item'>🏃 Matches: <strong>{$stats['matches']}</strong></div>";
                            }
                            if (isset($stats['yellow_cards'])) {
                                echo "<div class='stat-item'>🟡 Yellow Cards: <strong>{$stats['yellow_cards']}</strong></div>";
                            }
                            if (isset($stats['red_cards'])) {
                                echo "<div class='stat-item'>🔴 Red Cards: <strong>{$stats['red_cards']}</strong></div>";
                            }
                            echo "</div>";
                            echo "</div>";
                        }
                        
                        // Video Section
                        if (!empty($player['video_url'])) {
                            echo "<div style='margin-top: 1rem; padding: 1rem; background: #1a1a1a; border-radius: 8px;'>";
                            echo "<span class='info-label'>🎥 Video Highlights</span><br>";
                            echo "<a href='{$player['video_url']}' target='_blank' class='btn btn-info' style='margin-top: 0.5rem;'>Watch Highlights</a>";
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
                    <p><a href="mailto:nelson@footballagent.sl">📧 nelson@footballagent.sl</a></p>
                    <p><a href="tel:+23279826564">📞 +232 79 826-564</a></p>
                    <p><a href="https://www.google.com/maps/search/?api=1&query=Goderich+Street+Freetown+Sierra+Leone" target="_blank" rel="noopener">
                        📍 15 Goderich Street,<br>Freetown, Sierra Leone</a>
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
        
        // Initialize table view as default
        document.addEventListener('DOMContentLoaded', function() {
            toggleView('table');
        });
    </script>
</body>
</html>
<?php $conn->close(); ?>