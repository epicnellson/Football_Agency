<?php
// insert_sample_data.php
include "dbConnect.php";


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
            echo "✓ Created {$user[2]} user: {$user[0]}<br>";
            $insertedCount++;
        } else {
            echo "✗ Error creating {$user[2]} user: " . $conn->error . "<br>";
        }
    } else {
        echo "✓ {$user[2]} user '{$user[0]}' already exists<br>";
    }
}

echo "<br>✅ Sample data insertion completed. Total users inserted/verified: $insertedCount<br>";
echo "<br>🎯 All users can login with password: 'password'";

$conn->close();
?>