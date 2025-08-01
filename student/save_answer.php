<?php
session_start();
include '../db_config.php';

// Ensure student is logged in
if (!isset($_SESSION['student_logged_in']) || !isset($_SESSION['student_id'])) {
    header("Location: student_login.php");
    exit();
}

// Ensure exam context is valid
if (!isset($_POST['question_id']) || !isset($_POST['answer'])) {
    die("Invalid request.");
}

$student_id = $_SESSION['student_id'];
$question_id = intval($_POST['question_id']);
$selected_answer = $_POST['answer'];
$subject = $_SESSION['exam_subject'];

// Optional: sanitize input further if needed
$valid_answers = ['option1', 'option2', 'option3', 'option4'];
if (!in_array($selected_answer, $valid_answers)) {
    die("Invalid answer selected.");
}

// Prevent duplicate answer submission (if needed)
$check = $conn->prepare("SELECT id FROM student_answers WHERE student_id = ? AND question_id = ?");
$check->bind_param("ii", $student_id, $question_id);
$check->execute();
$result = $check->get_result();
if ($result->num_rows > 0) {
    $check->close();
    // Already answered, skip to next
    $_SESSION['current_question_index'] += 1;
    header("Location: exam.php");
    exit();
}
$check->close();

// Save the answer
$stmt = $conn->prepare("INSERT INTO student_answers (student_id, question_id, selected_answer, subject) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iiss", $student_id, $question_id, $selected_answer, $subject);
$stmt->execute();
$stmt->close();

// Move to next question
$_SESSION['current_question_index'] += 1;

// Redirect accordingly
if ($_SESSION['current_question_index'] >= count($_SESSION['exam_questions'])) {
    header("Location: exam_complete.php");
    exit();
} else {
    header("Location: exam.php");
    exit();
}
?>
