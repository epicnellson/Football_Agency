<?php
// tables/club_managers_table.php
include "../dbConnect.php";

$clubManagersTable = "CREATE TABLE IF NOT EXISTS club_managers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    club_name VARCHAR(100),
    club_location VARCHAR(100),
    club_level ENUM('Local', 'National', 'International'),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)";

if (mysqli_query($conn, $clubManagersTable)) {
    echo "Club managers table created/verified successfully<br>";
} else {
    echo "Error with club managers table: " . mysqli_error($conn) . "<br>";
}
?>