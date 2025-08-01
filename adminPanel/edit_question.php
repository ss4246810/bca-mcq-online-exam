<?php
session_start();

include '../db_config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "Invalid Request!";
    exit();
}

$id = $_GET['id'];

// Fetch existing question
$query = "SELECT * FROM questions WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo "Question not found!";
    exit();
}

$question = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = $_POST['subject'];
    $q_text = $_POST['question'];
    $option1 = $_POST['option1'];
    $option2 = $_POST['option2'];
    $option3 = $_POST['option3'];
    $option4 = $_POST['option4'];
    $correct = $_POST['correct'];

    // File upload (optional)
    $image = $question['image_path'];
    $audio = $question['audio_path'];
    $video = $question['video_path'];

    if (!empty($_FILES['image']['name'])) {
        $image = "uploads/" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }
    if (!empty($_FILES['audio']['name'])) {
        $audio = "uploads/" . basename($_FILES['audio']['name']);
        move_uploaded_file($_FILES['audio']['tmp_name'], $audio);
    }
    if (!empty($_FILES['video']['name'])) {
        $video = "uploads/" . basename($_FILES['video']['name']);
        move_uploaded_file($_FILES['video']['tmp_name'], $video);
    }

    $update = "UPDATE questions SET subject=?, question=?, option1=?, option2=?, option3=?, option4=?, correct_option=?, image_path=?, audio_path=?, video_path=? WHERE id=?";
    $stmt = $conn->prepare($update);
    $stmt->bind_param("ssssssssssi", $subject, $q_text, $option1, $option2, $option3, $option4, $correct, $image, $audio, $video, $id);
    
    if ($stmt->execute()) {
        header("Location: manage_questions.php");
        exit();
    } else {
        echo "Update failed!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Question</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        h2 {
            background-color: #343a40;
            color: white;
            padding: 20px;
            margin: 0;
            text-align: center;
        }

        form {
            max-width: 600px;
            margin: 30px auto;
            background: #fff;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        input[type="file"] {
            margin-top: 5px;
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        button {
            margin-top: 20px;
            padding: 12px 20px;
            background-color: #007bff;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #0056b3;
        }

        @media (max-width: 600px) {
            form {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
<h2>Edit Question</h2>
<form method="post" enctype="multipart/form-data">
    <label>Subject:</label>
    <input type="text" name="subject" value="<?= htmlspecialchars($question['subject']) ?>" required>

    <label>Question:</label>
    <textarea name="question" required><?= htmlspecialchars($question['question']) ?></textarea>

    <label>Option 1:</label>
    <input type="text" name="option1" value="<?= htmlspecialchars($question['option1']) ?>" required>

    <label>Option 2:</label>
    <input type="text" name="option2" value="<?= htmlspecialchars($question['option2']) ?>" required>

    <label>Option 3:</label>
    <input type="text" name="option3" value="<?= htmlspecialchars($question['option3']) ?>" required>

    <label>Option 4:</label>
    <input type="text" name="option4" value="<?= htmlspecialchars($question['option4']) ?>" required>

    <label>Correct Answer:</label>
    <select name="correct" required>
        <option value="option1" <?= $question['correct_option'] == "option1" ? "selected" : "" ?>>Option 1</option>
        <option value="option2" <?= $question['correct_option'] == "option2" ? "selected" : "" ?>>Option 2</option>
        <option value="option3" <?= $question['correct_option'] == "option3" ? "selected" : "" ?>>Option 3</option>
        <option value="option4" <?= $question['correct_option'] == "option4" ? "selected" : "" ?>>Option 4</option>
    </select>

    <label>Image:</label>
    <input type="file" name="image">

    <label>Audio:</label>
    <input type="file" name="audio">

    <label>Video:</label>
    <input type="file" name="video">

    <button type="submit">Update Question</button>
</form>
</body>
</html>
