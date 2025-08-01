<?php
session_start();
include '../db_config.php';

// Ensure the user is logged in
if (!isset($_SESSION['student_logged_in']) || !isset($_SESSION['student_id'])) {
    header("Location: student_login.php");
    exit();
}

// Get subject from GET or POST
$subject = $_GET['subject'] ?? $_POST['subject'] ?? null;

if (!$subject || empty(trim($subject))) {
    die("Error: Subject not selected.");
}

$subject = trim($subject);
$student_id = $_SESSION['student_id'];

// Check if there are at least 10 questions for this subject
$stmt = $conn->prepare("SELECT COUNT(*) FROM questions WHERE subject = ?");
$stmt->bind_param("s", $subject);
$stmt->execute();
$stmt->bind_result($totalQuestions);
$stmt->fetch();
$stmt->close();

if ($totalQuestions < 10) {
    die("Sorry, not enough questions available for subject: " . htmlspecialchars($subject));
}

// Check if student has already completed this subject
$stmt = $conn->prepare("SELECT COUNT(*) FROM exam_attempts WHERE student_id = ? AND subject = ?");
$stmt->bind_param("is", $student_id, $subject);
$stmt->execute();
$stmt->bind_result($attemptCount);
$stmt->fetch();
$stmt->close();

$alreadyAttempted = $attemptCount > 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Exam Instructions - <?php echo htmlspecialchars($subject); ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            height: 100vh;
            margin: 0;
        }
        .design {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin-top: -6%;
        }
        .instruction-box {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0px 0px 15px rgba(0,0,0,0.1);
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        ul {
            line-height: 1.7;
            color: #555;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 20px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .warning {
            color: red;
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<?php include 'navigation.php'; ?>
<div class="design">
    <div class="instruction-box">
        <h2>Instructions for <u><?php echo htmlspecialchars($subject); ?></u> Exam</h2>
        <ul>
            <li><strong>Total Questions:</strong> 10 (fetched using FIFO algorithm)</li>
            <li><strong>Total Time:</strong> 10 minutes (1 minute per question)</li>
            <li><strong>View:</strong> One question shown at a time</li>
            <li><strong>Time Limit:</strong> Each question has a countdown timer (1 minute)</li>
            <li><strong>Auto-selection:</strong> If no option is selected within time, a random answer will be auto-selected</li>
            <li><strong>Question Order:</strong> FIFO-based (oldest questions first)</li>
            <li><strong>Do not Refresh:</strong> Refreshing the page may terminate your exam</li>
        </ul>

        <?php if ($alreadyAttempted): ?>
            <p class="warning">⚠️ You have already completed the <strong><?php echo htmlspecialchars($subject); ?></strong> exam. Retake is not allowed.</p>
        <?php else: ?>
            <form action="start_exams.php" method="POST">
                <input type="hidden" name="subject" value="<?php echo htmlspecialchars($subject); ?>">
                <button type="submit">Start Exam</button>
            </form>
        <?php endif; ?>
    </div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
