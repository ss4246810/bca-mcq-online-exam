<?php
session_start();

// If already logged in, redirect to actual student home
if (isset($_SESSION['student_logged_in'])) {
    header("Location: student_home.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome to BCA MCQ Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #f0f2f5;
        }

        header {
            background-color: #1a73e8;
            color: white;
            padding: 20px 40px;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 30px;
        }

        .register-banner {
            background: #fff3cd;
            color: #856404;
            text-align: center;
            padding: 20px;
            font-size: 18px;
            border-bottom: 1px solid #ffeeba;
        }

        .register-banner a {
            display: inline-block;
            margin-top: 10px;
            background: #1a73e8;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 6px;
            transition: background 0.3s ease;
        }

        .register-banner a:hover {
            background: #155ab6;
        }

        .intro {
            text-align: center;
            margin: 30px auto;
            max-width: 700px;
        }

        .intro p {
            font-size: 18px;
            color: #444;
        }

        .features {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 25px;
            padding: 30px 20px;
        }

        .feature-box {
            background: white;
            width: 280px;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .feature-box:hover {
            transform: translateY(-5px);
        }

        .feature-box h3 {
            color: #1a73e8;
        }

        .feature-box p {
            color: #666;
        }

        .feature-box a {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background: #1a73e8;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.3s ease;
        }

        .feature-box a:hover {
            background: #155ab6;
        }

        footer {
            text-align: center;
            padding: 20px;
            background: #e9ecef;
            margin-top: 40px;
            color: #777;
        }
    </style>
</head>
<body>

<header>
    <h1>Welcome to BCA MCQ Exam Platform</h1>
</header>

<div class="register-banner">
    <strong>New to our platform?</strong> Register now to unlock all features like MCQ exams, result tracking, and more!<br>
    <a href="student_register.php">Register Now</a>
</div>

<div class="intro">
    <p>Practice, Learn, and Test your skills in various BCA subjects using our smart MCQ system.</p>
</div>

<div class="features">
    <div class="feature-box">
        <h3>Start Exam</h3>
        <p>Attempt subject-wise MCQ exams and track your performance.</p>
        <a href="student_login.php">Login to Start</a>
    </div>

    <div class="feature-box">
        <h3>View Results</h3>
        <p>Check your past exam attempts and scores in detail.</p>
        <a href="student_login.php">Login to View</a>
    </div>

    <div class="feature-box">
        <h3>Progress Analysis</h3>
        <p>Coming soon: Visual analytics of your learning curve.</p>
        <a href="student_login.php">Login Required</a>
    </div>
</div>

<footer>
    &copy; <?= date('Y') ?> BCA Online Exam. All rights reserved.
</footer>

</body>
</html>
