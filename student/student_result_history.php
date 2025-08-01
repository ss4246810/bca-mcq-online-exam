<?php
session_start();
include '../db_config.php';

// Ensure student is logged in
if (!isset($_SESSION['student_logged_in']) || !isset($_SESSION['student_id'])) {
    header("Location: student_login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// Fetch exam history
$stmt = $conn->prepare("
    SELECT subject, score, total_questions, correct_answers, wrong_answers, attempted_at
    FROM exam_attempts
    WHERE student_id = ?
    ORDER BY attempted_at DESC
");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Exam History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background: #f2f2f2;
        }
    </style>
</head>
<body>
<?php include 'navigation.php'; ?>
<div class="container">
    <h2>My Exam History</h2>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Score</th>
                    <th>Correct</th>
                    <th>Wrong</th>
                    <th>Total Questions</th>
                    <th>Date & Time</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['subject']) ?></td>
                        <td><?= $row['score'] ?></td>
                        <td><?= $row['correct_answers'] ?></td>
                        <td><?= $row['wrong_answers'] ?></td>
                        <td><?= $row['total_questions'] ?></td>
                        <td><?= date('d-M-Y h:i A', strtotime($row['attempted_at'])) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align: center;">You haven't taken any exams yet.</p>
    <?php endif; ?>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
