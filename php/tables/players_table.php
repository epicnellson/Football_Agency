<?php
// tables/players_table.php
include "../dbConnect.php";


$playersTable = "CREATE TABLE IF NOT EXISTS players (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    date_of_birth DATE,
    position ENUM('Goalkeeper', 'Defender', 'Midfielder', 'Forward'),
    height DECIMAL(5,2),
    weight DECIMAL(5,2),
    preferred_foot ENUM('Left', 'Right', 'Both'),
    current_club VARCHAR(100),
    agent_id INT,
    video_url VARCHAR(255),
    stats TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (agent_id) REFERENCES users(id)
)";

if (mysqli_query($conn, $playersTable)) {
    echo "Players table created/verified successfully<br>";
} else {
    echo "Error with players table: " . mysqli_error($conn) . "<br>";
}
?>