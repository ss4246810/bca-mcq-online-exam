<?php
session_start();
include '../db_config.php';

if (!isset($_SESSION['student_logged_in']) || !isset($_SESSION['student_id'])) {
    header("Location: student_login.php");
    exit();
}

if (!isset($_SESSION['exam_subject'])) {
    die("No subject found in session.");
}

$student_id = $_SESSION['student_id'];
$subject = $_SESSION['exam_subject'];

// Check if student has already completed this exam
$checkStmt = $conn->prepare("SELECT id FROM exam_attempts WHERE student_id = ? AND subject = ?");
$checkStmt->bind_param("is", $student_id, $subject);
$checkStmt->execute();
$checkStmt->store_result();

if ($checkStmt->num_rows > 0) {
    $checkStmt->close();
    // Show existing result (you may redirect or notify)
    header("Location: student_result_history.php?subject=" . urlencode($subject));
    exit();
}
$checkStmt->close();

// Calculate result
$stmt = $conn->prepare("
    SELECT sa.question_id, sa.selected_answer, q.correct_option 
    FROM student_answers sa 
    JOIN questions q ON sa.question_id = q.id 
    WHERE sa.student_id = ? AND sa.subject = ?
");
$stmt->bind_param("is", $student_id, $subject);
$stmt->execute();
$result = $stmt->get_result();

$correct = $wrong = $total_questions = 0;
while ($row = $result->fetch_assoc()) {
    $total_questions++;
    if ($row['selected_answer'] === $row['correct_option']) {
        $correct++;
    } else {
        $wrong++;
    }
}
$stmt->close();

$score = $correct;

// Save final result
$insertStmt = $conn->prepare("INSERT INTO exam_attempts 
    (student_id, subject, score, total_questions, correct_answers, wrong_answers)
    VALUES (?, ?, ?, ?, ?, ?)");
$insertStmt->bind_param("isiiii", $student_id, $subject, $score, $total_questions, $correct, $wrong);
$insertStmt->execute();
$insertStmt->close();

// Optionally clear answers after saving
// $conn->query("DELETE FROM student_answers WHERE student_id = $student_id AND subject = '$subject'");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Exam Completed</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            text-align: center;
            padding: 50px;
        }
        .result-box {
            background: #fff;
            max-width: 600px;
            margin: auto;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .summary {
            font-size: 18px;
            margin-top: 20px;
            color: #555;
        }
        .summary strong {
            color: #000;
        }
        .back-btn {
            display: inline-block;
            margin-top: 30px;
            padding: 10px 20px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
        }
        .back-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="result-box">
        <h2>Exam Completed!</h2>
        <div class="summary">
            <p><strong>Subject:</strong> <?= htmlspecialchars($subject) ?></p>
            <p><strong>Total Questions:</strong> <?= $total_questions ?></p>
            <p><strong>Correct Answers:</strong> <?= $correct ?></p>
            <p><strong>Wrong Answers:</strong> <?= $wrong ?></p>
            <p><strong>Your Score:</strong> <?= $score ?> / <?= $total_questions ?></p>
        </div>
        <a class="back-btn" href="student_result_history.php">View Result History</a>
    </div>
</body>
</html>
