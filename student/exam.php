<?php
session_start();
include '../db_config.php';

// Ensure student is logged in
if (!isset($_SESSION['student_logged_in']) || !isset($_SESSION['student_id'])) {
    header("Location: student_login.php");
    exit();
}

// Ensure subject and questions are set in session
if (!isset($_SESSION['exam_subject']) || !isset($_SESSION['exam_questions'])) {
    die("Exam not properly initialized. Please go back and start again.");
}

$subject = $_SESSION['exam_subject'];
$questions = $_SESSION['exam_questions'];

// Initialize current index
if (!isset($_SESSION['current_question_index'])) {
    $_SESSION['current_question_index'] = 0;
}

$currentIndex = $_SESSION['current_question_index'];

// End exam if all questions are completed
if ($currentIndex >= count($questions)) {
    header("Location: exam_complete.php");
    exit();
}

// Get current question ID
$current_question_id = $questions[$currentIndex];

// Fetch question from DB
$stmt = $conn->prepare("SELECT * FROM questions WHERE id = ? AND subject = ?");
$stmt->bind_param("is", $current_question_id, $subject);
$stmt->execute();
$result = $stmt->get_result();
$question = $result->fetch_assoc();
$stmt->close();

if (!$question) {
    die("Error: Question not found or subject mismatch. Please restart the exam.");
}

// Timer and refresh logic
$now = time();
$questionKey = 'qtime_' . $question['id'];

if (!isset($_SESSION[$questionKey])) {
    $_SESSION[$questionKey] = [
        'start_time' => $now,
        'refresh_count' => 0
    ];
} else {
    if (!isset($_GET['norefresh'])) {
        $_SESSION[$questionKey]['refresh_count']++;

        if ($_SESSION[$questionKey]['refresh_count'] == 1) {
            // First refresh - deduct 5 seconds
            $_SESSION[$questionKey]['start_time'] = $now - 5;
            $_SESSION['refresh_flag'] = "first";
        } else {
            // Multiple refreshes
            $_SESSION['refresh_flag'] = "multiple";
        }

        header("Location: " . $_SERVER['PHP_SELF'] . "?norefresh=1");
        exit();
    }
}

$start_time = $_SESSION[$questionKey]['start_time'];
$timePassed = $now - $start_time;
$timeLeft = max(0, 60 - $timePassed);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Exam - Question <?php echo $currentIndex + 1; ?></title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #f5f7fa, #c3cfe2);
            height: 100vh;
            display: grid;
            place-items: center;
        }
        .exam-box {
            background: #ffffff;
            max-width: 750px;
            width: 90%;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s ease-in-out;
        }
        .timer {
            color: #dc3545;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: right;
        }
        h3 {
            font-size: 22px;
            color: #333;
            margin-bottom: 25px;
            line-height: 1.4;
        }
        .option {
            margin: 15px 0;
            background: #f8f9fa;
            border-radius: 8px;
            padding: 12px 15px;
            border: 1px solid #ddd;
        }
        .option:hover { background: #e9ecef; }
        .option input {
            margin-right: 10px;
            transform: scale(1.2);
            cursor: pointer;
        }
        button {
            background: #007bff;
            color: #fff;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 25px;
            display: block;
            margin-left: auto;
        }
        button:hover {
            background: #0056b3;
            transform: translateY(-1px);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    <script>
        let timeLeft = <?php echo $timeLeft; ?>;
        let submitted = false;

        function countdown() {
            const timerDisplay = document.getElementById("timer");
            const interval = setInterval(() => {
                timeLeft--;
                timerDisplay.innerText = "Time Left: " + timeLeft + "s";
                if (timeLeft <= 0 && !submitted) {
                    clearInterval(interval);
                    autoSelectAndSubmit();
                }
            }, 1000);
        }

        function autoSelectAndSubmit() {
            let options = document.querySelectorAll('input[name="answer"]');
            let randomIndex = Math.floor(Math.random() * options.length);
            if (options[randomIndex]) {
                options[randomIndex].checked = true;
            }
            document.getElementById("examForm").submit();
            submitted = true;
        }

        window.onload = () => {
            countdown();
            <?php if (!empty($_SESSION['refresh_flag'])): ?>
                <?php if ($_SESSION['refresh_flag'] === "first"): ?>
                    alert("⚠️ You refreshed the page. 5 seconds have been deducted!");
                <?php elseif ($_SESSION['refresh_flag'] === "multiple"): ?>
                    alert("⛔ You already refreshed once. No more refreshes allowed for this question!");
                <?php endif; ?>
                <?php unset($_SESSION['refresh_flag']); ?>
            <?php endif; ?>
        };
    </script>
</head>
<body>
    <div class="exam-box">
        <div class="timer" id="timer">Time Left: <?php echo $timeLeft; ?>s</div>
        <form id="examForm" action="save_answer.php" method="POST">
            <input type="hidden" name="question_id" value="<?php echo $question['id']; ?>">
            <h3><?php echo "Q" . ($currentIndex + 1) . ". " . htmlspecialchars($question['question']); ?></h3>
            <div class="option"><label><input type="radio" name="answer" value="option1"> <?php echo htmlspecialchars($question['option1']); ?></label></div>
            <div class="option"><label><input type="radio" name="answer" value="option2"> <?php echo htmlspecialchars($question['option2']); ?></label></div>
            <div class="option"><label><input type="radio" name="answer" value="option3"> <?php echo htmlspecialchars($question['option3']); ?></label></div>
            <div class="option"><label><input type="radio" name="answer" value="option4"> <?php echo htmlspecialchars($question['option4']); ?></label></div>
            <button type="submit">Next</button>
        </form>
    </div>
</body>
</html>
