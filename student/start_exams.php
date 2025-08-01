<?php
session_start();
include '../db_config.php';

// Check if student is logged in
if (!isset($_SESSION['student_logged_in']) || !isset($_SESSION['student_id'])) {
    header("Location: student_login.php");
    exit();
}

// Get subject from POST
if (!isset($_POST['subject']) || empty(trim($_POST['subject']))) {
    die("Error: Subject not selected.");
}

$subject = trim($_POST['subject']);

// Fetch 10 FIFO questions for the subject
$stmt = $conn->prepare("SELECT id, question, option1, option2, option3, option4, correct_option, image_path, audio_path, video_path 
                        FROM questions 
                        WHERE subject = ? 
                        ORDER BY id ASC 
                        LIMIT 10");
$stmt->bind_param("s", $subject);
$stmt->execute();
$result = $stmt->get_result();

$questions = [];
while ($row = $result->fetch_assoc()) {
    $questions[] = $row;
}
$stmt->close();

if (count($questions) < 10) {
    die("Error: Not enough questions found for subject: " . htmlspecialchars($subject));
}

// ✅ Store questions, subject, and progress in session
$_SESSION['exam_subject'] = $subject; // <-- This line was missing before
$_SESSION['exam'] = [
    'subject' => $subject,
    'questions' => $questions,
    'current' => 0,
    'answers' => [],
    'start_time' => time()
];


// ✅ Also initialize question index and question ID array
$_SESSION['current_question_index'] = 0;
$_SESSION['exam_questions'] = array_column($questions, 'id');

// Redirect to first question
header("Location: exam.php");
exit();
?>
