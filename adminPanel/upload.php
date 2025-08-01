<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = $_POST['subject'];
    $question = $_POST['question'];
    $option1 = $_POST['option1'];
    $option2 = $_POST['option2'];
    $option3 = $_POST['option3'];
    $option4 = $_POST['option4'];
    $correct = $_POST['correct'];

    // File Upload Handling
    $image_path = "";
    $audio_path = "";
    $video_path = "";

    if (!empty($_FILES['image']['name'])) {
        $image_path = "../uploads/" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
    }
    if (!empty($_FILES['audio']['name'])) {
        $audio_path = "uploads/" . basename($_FILES['audio']['name']);
        move_uploaded_file($_FILES['audio']['tmp_name'], $audio_path);
    }
    if (!empty($_FILES['video']['name'])) {
        $video_path = "uploads/" . basename($_FILES['video']['name']);
        move_uploaded_file($_FILES['video']['tmp_name'], $video_path);
    }

    // Insert into database
    $query = "INSERT INTO questions (subject, question, option1, option2, option3, option4, correct_option, image_path, audio_path, video_path) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssssss", $subject, $question, $option1, $option2, $option3, $option4, $correct, $image_path, $audio_path, $video_path);

    if ($stmt->execute()) {
        $success = "Question added successfully!";
    } else {
        $error = "Error adding question: " . $conn->error;
    }
}
?>