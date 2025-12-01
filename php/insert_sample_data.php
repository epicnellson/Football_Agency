<?php
// insert_sample_data_fixed.php
include "dbConnect.php";

echo "<h2>Sample Data Insertion - Fixed Version</h2>";

// Sample data for 2 users per role
$sampleUsers = [
    // Admin users
    ['admin1', 'admin1@footballagent.sl', 'admin', 'System', 'Administrator', '+232 00 000-001', '15 Goderich Street, Freetown'],
    ['admin2', 'admin2@footballagent.sl', 'admin', 'Sarah', 'Johnson', '+232 00 000-002', 'Freetown Office'],
    
    // Player users
    ['musa_tombo', 'musa.tombo@example.com', 'player', 'Musa', 'Tombo', '+232 79 123-456', 'Freetown, Sierra Leone'],
    ['kai_kamara', 'kai.kamara@example.com', 'player', 'Kai', 'Kamara', '+232 79 123-457', 'Bo City, Sierra Leone'],
    
    // Agent users
    ['nelson_agent', 'nelson@footballagent.sl', 'agent', 'Nelson', 'Football Agent', '+232 79 826-564', '15 Goderich Street, Freetown'],
    ['sarah_agent', 'sarah.agent@example.com', 'agent', 'Sarah', 'Conteh', '+232 79 826-565', 'Freetown Office'],
    
    // Club Manager users
    ['club_manager1', 'manager@fcsl.com', 'club_manager', 'John', 'Manager', '+232 88 765-432', 'Freetown Stadium'],
    ['club_manager2', 'director@asfc.com', 'club_manager', 'David', 'Koroma', '+232 88 765-433', 'Bo Stadium']
];

$hashedPassword = password_hash('password', PASSWORD_DEFAULT);
$insertedCount = 0;
$userIds = [];

echo "<h3>Step 1: Creating Users</h3>";
foreach ($sampleUsers as $user) {
    $checkUser = "SELECT id FROM users WHERE username = ?";
    $stmt = $conn->prepare($checkUser);
    $stmt->bind_param("s", $user[0]);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        $insertUser = "INSERT INTO users (username, email, password, role, first_name, last_name, phone, address) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($insertUser);
        $stmt->bind_param("ssssssss", $user[0], $user[1], $hashedPassword, $user[2], $user[3], $user[4], $user[5], $user[6]);
        
        if ($stmt->execute()) {
            $userId = $conn->insert_id;
            $userIds[$user[0]] = $userId;
            echo "✓ Created {$user[2]} user: {$user[0]} (ID: $userId)<br>";
            $insertedCount++;
        } else {
            echo "✗ Error creating {$user[2]} user: " . $conn->error . "<br>";
        }
    } else {
        $row = $result->fetch_assoc();
        $userIds[$user[0]] = $row['id'];
        echo "✓ {$user[2]} user '{$user[0]}' already exists (ID: {$row['id']})<br>";
    }
}

echo "<h3>Step 2: Creating Player Profiles</h3>";
// Insert Player Data - matching your players table structure
$playerData = [
    // [username, position, height, weight, preferred_foot, current_club, agent_username]
    ['musa_tombo', 'Forward', 180.5, 75.0, 'Right', 'East End FC', 'nelson_agent'],
    ['kai_kamara', 'Midfielder', 175.0, 70.0, 'Both', 'Bo Rangers', 'sarah_agent']
];

foreach ($playerData as $player) {
    $username = $player[0];
    if (isset($userIds[$username])) {
        $userId = $userIds[$username];
        $agentId = isset($userIds[$player[6]]) ? $userIds[$player[6]] : null;
        
        $checkPlayer = "SELECT id FROM players WHERE user_id = ?";
        $stmt = $conn->prepare($checkPlayer);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 0) {
            // Using your exact players table structure
            $insertPlayer = "INSERT INTO players (user_id, position, height, weight, preferred_foot, current_club, agent_id) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $conn->prepare($insertPlayer);
            // FIXED: Changed to 'isddsii' - 7 parameters for 7 variables
            // i=user_id, s=position, d=height, d=weight, s=preferred_foot, s=current_club, i=agent_id
            $stmt->bind_param("isddsii", $userId, $player[1], $player[2], $player[3], $player[4], $player[5], $agentId);
            
            if ($stmt->execute()) {
                echo "✓ Created player profile for: {$username}<br>";
            } else {
                echo "✗ Error creating player profile for {$username}: " . $conn->error . "<br>";
                echo "Debug: userId=$userId, position={$player[1]}, height={$player[2]}, weight={$player[3]}, foot={$player[4]}, club={$player[5]}, agentId=$agentId<br>";
            }
        } else {
            echo "✓ Player profile for '{$username}' already exists<br>";
        }
    } else {
        echo "✗ User ID not found for username: {$username}<br>";
    }
}

echo "<h3>Step 3: Creating Agent Profiles</h3>";
// Insert Agent Data - matching your agents table structure
$agentData = [
    ['nelson_agent', 'AGENT-SL-001', 8, 'Youth Development & International Transfers'],
    ['sarah_agent', 'AGENT-SL-002', 5, 'Player Management & Contracts']
];

foreach ($agentData as $agent) {
    $username = $agent[0];
    if (isset($userIds[$username])) {
        $userId = $userIds[$username];
        
        $checkAgent = "SELECT id FROM agents WHERE user_id = ?";
        $stmt = $conn->prepare($checkAgent);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 0) {
            // Using your exact agents table structure
            $insertAgent = "INSERT INTO agents (user_id, license_number, years_experience, specialization) 
                           VALUES (?, ?, ?, ?)";
            
            $stmt = $conn->prepare($insertAgent);
            $stmt->bind_param("isis", $userId, $agent[1], $agent[2], $agent[3]);
            
            if ($stmt->execute()) {
                echo "✓ Created agent profile for: {$username}<br>";
            } else {
                echo "✗ Error creating agent profile for {$username}: " . $conn->error . "<br>";
            }
        } else {
            echo "✓ Agent profile for '{$username}' already exists<br>";
        }
    }
}

echo "<h3>Step 4: Creating Club Manager Profiles</h3>";
// Insert Club Manager Data - matching your club_managers table structure
$clubManagerData = [
    // [username, club_name, club_location, club_level]
    ['club_manager1', 'Freetown City FC', 'Freetown', 'National'],
    ['club_manager2', 'Bo United SC', 'Bo City', 'Local']
];

foreach ($clubManagerData as $clubManager) {
    $username = $clubManager[0];
    if (isset($userIds[$username])) {
        $userId = $userIds[$username];
        
        $checkClubManager = "SELECT id FROM club_managers WHERE user_id = ?";
        $stmt = $conn->prepare($checkClubManager);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 0) {
            // Using your exact club_managers table structure
            $insertClubManager = "INSERT INTO club_managers (user_id, club_name, club_location, club_level) 
                                VALUES (?, ?, ?, ?)";
            
            $stmt = $conn->prepare($insertClubManager);
            $stmt->bind_param("isss", $userId, $clubManager[1], $clubManager[2], $clubManager[3]);
            
            if ($stmt->execute()) {
                echo "✓ Created club manager profile for: {$username}<br>";
            } else {
                echo "✗ Error creating club manager profile for {$username}: " . $conn->error . "<br>";
            }
        } else {
            echo "✓ Club manager profile for '{$username}' already exists<br>";
        }
    }
}

echo "<h3>Step 5: Updating Agent Player Counts</h3>";
// Update agent player counts
$updateAgentCounts = "UPDATE agents a 
                     SET total_players = (
                         SELECT COUNT(*) 
                         FROM players p 
                         WHERE p.agent_id = a.user_id
                     )";
if ($conn->query($updateAgentCounts)) {
    echo "✓ Updated agent player counts<br>";
} else {
    echo "✗ Error updating agent player counts: " . $conn->error . "<br>";
}

echo "<h3>Final Summary</h3>";
echo "✅ Data insertion process completed!<br>";
echo "📊 Users created: $insertedCount<br>";

// Verify data was inserted in all tables
echo "<h3>Data Verification:</h3>";
$verifyTables = [
    'users' => 'SELECT COUNT(*) as count FROM users',
    'players' => 'SELECT COUNT(*) as count FROM players', 
    'agents' => 'SELECT COUNT(*) as count FROM agents',
    'club_managers' => 'SELECT COUNT(*) as count FROM club_managers'
];

foreach ($verifyTables as $table => $query) {
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_assoc();
        echo "Table <strong>{$table}</strong>: {$row['count']} records<br>";
    } else {
        echo "Table <strong>{$table}</strong>: Error counting records<br>";
    }
}

echo "<h3>Sample Login Credentials:</h3>";
echo "All users can login with:<br>";
echo "- Username: as shown above<br>"; 
echo "- Password: 'password'<br>";
echo "<br>";
echo "🔗 Player-Agent Relationships:<br>";
echo "- Musa Tombo (Forward) → Nelson Agent<br>";
echo "- Kai Kamara (Midfielder) → Sarah Agent<br>";

$conn->close();
?>