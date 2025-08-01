<?php
session_start();
include '../db_config.php';

// Check if student is logged in
if (!isset($_SESSION['student_logged_in'])) {
    header("Location: student_login.php");
    exit();
}

// Fetch subjects with their question counts
$sql = "SELECT q.subject, COUNT(*) AS question_count, 
               COALESCE(es.is_enabled, 0) AS is_enabled
        FROM questions q
        LEFT JOIN exam_status es ON q.subject = es.subject
        GROUP BY q.subject
        HAVING question_count > 0";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Start Exam</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
        }
        .subject-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            background: #fafafa;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .subject-card button {
            background-color: #007bff;
            border: none;
            padding: 10px 15px;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .subject-card button:disabled {
            background-color: #aaa;
            cursor: not-allowed;
        }
        .subject-card button:hover:enabled {
            background-color: #0056b3;
        }
        .status {
            font-size: 14px;
            color: #555;
            margin-top: 5px;
        }
    </style>
</head>
<body>
<?php include 'navigation.php'; ?>

<div class="container">
    <h2>Select Subject to Start Exam</h2>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="subject-card">
                <div>
                    <strong><?= htmlspecialchars($row['subject']) ?></strong><br>
                    <?= (int)$row['question_count'] ?> questions available
                    <div class="status">
                        Status: <span style="color: <?= $row['is_enabled'] ? 'green' : 'red' ?>;">
                            <?= $row['is_enabled'] ? 'Enabled' : 'Disabled' ?>
                        </span>
                    </div>
                </div>
                <form action="exam_instructions.php" method="POST">
                    <input type="hidden" name="subject" value="<?= htmlspecialchars($row['subject']) ?>">
                    <button type="submit" <?= $row['is_enabled'] ? '' : 'disabled' ?>>Start Exam</button>
                </form>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No subjects available for exam.</p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
