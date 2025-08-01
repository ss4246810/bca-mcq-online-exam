<?php
include '../db_config.php';
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
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

    $image_path = "";
    $audio_path = "";
    $video_path = "";

    if (!empty($_FILES['image']['name'])) {
        $image_path = "uploads/" . basename($_FILES['image']['name']);
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Question</title>
    <style>
        /* Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: #333;
        }

        h1 {
            text-align: center;
            padding: 20px 0;
            color: #1f2937;
        }

        /* Navigation Bar */
        nav {
            background-color: #1f2937;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
            gap: 40px;
            padding: 14px 0;
        }

        nav ul li a {
            color: #ffffff;
            text-decoration: none;
            font-size: 18px;
            padding: 10px 18px;
            border-radius: 6px;
            transition: background 0.3s, transform 0.2s;
        }

        nav ul li a:hover {
            background-color: #3b82f6;
            transform: translateY(-2px);
        }

        /* Section */
        section {
            max-width: 700px;
            margin: 30px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }

        input[type="text"],
        textarea,
        select,
        input[type="file"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            background-color: #f9fafb;
            transition: border 0.3s;
        }

        input:focus,
        textarea:focus,
        select:focus {
            border-color: #2563eb;
            outline: none;
        }

        button {
            background-color: #2563eb;
            color: #fff;
            padding: 12px 25px;
            border: none;
            font-size: 16px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
        }

        button:hover {
            background-color: #1e40af;
            transform: translateY(-2px);
        }

        .success {
            background-color: #d1e7dd;
            color: #0f5132;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .error {
            background-color: #f8d7da;
            color: #842029;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            nav ul {
                flex-direction: column;
                gap: 15px;
                padding: 10px 0;
            }

            section {
                margin: 20px 15px;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

    <?php include 'admin_nav.php'; ?>
    <h1>Add New MCQ Question</h1>

    <section>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <form action="" method="post" enctype="multipart/form-data">
            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" required>

            <label for="question">Question:</label>
            <textarea id="question" name="question" rows="4" required></textarea>

            <label for="option1">Option 1:</label>
            <input type="text" id="option1" name="option1" required>

            <label for="option2">Option 2:</label>
            <input type="text" id="option2" name="option2" required>

            <label for="option3">Option 3:</label>
            <input type="text" id="option3" name="option3" required>

            <label for="option4">Option 4:</label>
            <input type="text" id="option4" name="option4" required>

            <label for="correct">Correct Answer:</label>
            <select id="correct" name="correct" required>
                <option value="option1">Option 1</option>
                <option value="option2">Option 2</option>
                <option value="option3">Option 3</option>
                <option value="option4">Option 4</option>
            </select>

            <label for="image">Upload Image:</label>
            <input type="file" id="image" name="image">

            <label for="audio">Upload Audio:</label>
            <input type="file" id="audio" name="audio">

            <label for="video">Upload Video:</label>
            <input type="file" id="video" name="video">

            <button type="submit">Add Question</button>
        </form>
    </section>
</body>
</html>
