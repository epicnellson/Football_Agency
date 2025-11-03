<?php
// tables/agents_table.php
include "../dbConnect.php";

$agentsTable = "CREATE TABLE IF NOT EXISTS agents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    license_number VARCHAR(50),
    years_experience INT,
    specialization TEXT,
    total_players INT DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)";

if (mysqli_query($conn, $agentsTable)) {
    echo "Agents table created/verified successfully<br>";
} else {
    echo "Error with agents table: " . mysqli_error($conn) . "<br>";
}
?>