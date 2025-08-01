<?php
session_start();
include '../db_config.php';

$student_id = $_SESSION['student_id'] ?? 0;
if (!$student_id) {
    die("Unauthorized access.");
}

// Initialize score
if (!isset($_SESSION['score'])) $_SESSION['score'] = 0;
if (!isset($_SESSION['attempted'])) $_SESSION['attempted'] = 0;
if (!isset($_SESSION['current_difficulty'])) $_SESSION['current_difficulty'] = 'Easy';

$current_difficulty = $_SESSION['current_difficulty'];

// Fetch a question if not already set or after submitting
if (!isset($_SESSION['current_question']) || isset($_POST['next'])) {
    $sql = "SELECT * FROM practice_questions WHERE difficulty = ? ORDER BY RAND() LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $current_difficulty);
    $stmt->execute();
    $result = $stmt->get_result();
    $question = $result->fetch_assoc();

    if (!$question) {
        echo "No questions found for $current_difficulty.";
        exit;
    }

    $_SESSION['current_question'] = $question;
} else {
    $question = $_SESSION['current_question'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Practice Zone</title>
    <style>
        .question-box { padding: 20px; border: 1px solid #ccc; border-radius: 10px; width: 600px; margin: auto; }
        .option { margin: 10px 0; }
        .btn { padding: 10px 20px; margin-top: 10px; }
        .result { margin-top: 20px; font-weight: bold; }
    </style>
</head>
<body>

<?php include 'navigation.php'; ?>

<div class="question-box">
    <h3>Score: <?= $_SESSION['score'] ?>/<?= $_SESSION['attempted'] ?> |
        Current Difficulty: <?= htmlspecialchars($current_difficulty) ?></h3>

    <p><strong>Q:</strong> <?= htmlspecialchars($question['question']) ?></p>

    <?php if (!isset($_POST['submit'])): ?>
        <form method="post">
            <?php foreach (['a', 'b', 'c', 'd'] as $opt): ?>
                <div class="option">
                    <label>
                        <input type="radio" name="selected_option" value="<?= strtoupper($opt) ?>" required>
                        <?= strtoupper($opt) ?>. <?= htmlspecialchars($question["option_$opt"]) ?>
                    </label>
                </div>
            <?php endforeach; ?>
            <input type="submit" name="submit" value="Show Answer" class="btn">
        </form>
    <?php else: ?>
        <?php
        $selected = $_POST['selected_option'] ?? '';
        $correct = $question['correct_option'];
        $is_correct = ($selected === $correct);

        // Store attempt
        $stmt = $conn->prepare("INSERT INTO practice_attempts (student_id, question_id, selected_option, is_correct) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iisi", $student_id, $question['id'], $selected, $is_correct);
        $stmt->execute();

        $_SESSION['attempted']++;
        if ($is_correct) $_SESSION['score']++;

        // Simple algorithm to change difficulty
        if ($is_correct && $current_difficulty === 'Easy') $_SESSION['current_difficulty'] = 'Medium';
        elseif ($is_correct && $current_difficulty === 'Medium') $_SESSION['current_difficulty'] = 'Hard';
        elseif (!$is_correct && $current_difficulty === 'Hard') $_SESSION['current_difficulty'] = 'Medium';
        elseif (!$is_correct && $current_difficulty === 'Medium') $_SESSION['current_difficulty'] = 'Easy';

        ?>
        <div class="result">
            <?php if ($is_correct): ?>
                <span style="color: green;">Correct ✅</span>
            <?php else: ?>
                <span style="color: red;">Wrong ❌. Correct Answer: <?= $correct ?></span>
            <?php endif; ?>
            <p><strong>Explanation:</strong> <?= htmlspecialchars($question['explanation']) ?></p>
            <form method="post">
                <input type="submit" name="next" value="Next Question" class="btn">
            </form>
        </div>
        <?php unset($_SESSION['current_question']); ?>
    <?php endif; ?>
</div>

</body>
</html>
