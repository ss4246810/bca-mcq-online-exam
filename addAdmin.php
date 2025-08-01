<?php
include 'db_config.php';

$username = "suresh"; // Change this to your desired username
$password = password_hash("suresh123", PASSWORD_DEFAULT); // Change this to your password

$query = "INSERT INTO admins (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $username, $password);
if ($stmt->execute()) {
    echo "Admin user created successfully!";
} else {
    echo "Error: " . $conn->error;
}
?>
