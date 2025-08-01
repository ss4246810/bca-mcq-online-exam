<?php
// student_home.php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['student_logged_in']) || !isset($_SESSION['email'])) {
    header("Location: student_login.php");
    exit();
}

$student_name = $_SESSION['student_name'] ?? 'Student'; // You can set this in login/OTP phase
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard - BCA MCQ Exam</title>
    <style>
        .dashboard {
    display: flex;
    gap: 20px;
    margin-top: 20px;
    flex-wrap: wrap;
}

.card {
    flex: 1;
    min-width: 200px;
    max-width: 300px;
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    transition: transform 0.2s ease;
    cursor: pointer;
}

.card:hover {
    transform: translateY(-5px);
    background-color: #f8f9fa;
}

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f4f4f4;
        }
        header {
            background-color: #007bff;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header h2 {
            margin: 0;
        }
        nav a {
            color: white;
            margin-left: 15px;
            text-decoration: none;
            font-weight: bold;
        }
        nav a:hover {
            text-decoration: underline;
        }
        .container {
            padding: 30px;
        }
        footer {
            background-color: #222;
            color: #ccc;
            padding: 10px 20px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<header>
    <h2>Welcome, <?php echo htmlspecialchars($student_name); ?></h2>
    <nav>
        <a href="student_home.php">Home</a>
        <a href="start_exam.php">Start Exam</a>
        <a href="#">My Results</a>
        <a href="#">Profile</a>
        <a href="studentLogout.php">Logout</a>
    </nav>
</header>
<!-- 
<div class="container">
    <h3>Student Dashboard</h3>
    <p>Use the navigation bar to start your exam, view results, or update your profile.</p>
</div> -->
<div class="container">
    <h3>Student Dashboard</h3>
    <div class="dashboard">
        <div class="card" onclick="location.href='start_exam.php';">
            <h4>Start MCQ Exam</h4>
            <p>Begin your online test now.</p>
        </div>
        <div class="card" onclick="location.href='student_result_history.php';">
            <h4>View My Results</h4>
            <p>Check your performance and scores.</p>
        </div>
        <div class="card" onclick="location.href='profile.php';">
            <h4>Edit Profile</h4>
            <p>Update your personal information.</p>
        </div>
    </div>
</div>
<!-- 🔧 Practice Zone Starts Here -->
    <h3 style="margin-top: 40px;">🧠 Practice Zone</h3>
    <div class="dashboard">
        <div class="card" onclick="location.href='practice_difficulty.php';">
            <h4>Difficulty-Level Practice</h4>
            <p>Practice easy, medium, and hard questions.</p>
        </div>
        <div class="card" onclick="location.href='practice_topic.php';">
            <h4>Topic-Wise Practice</h4>
            <p>Select questions based on subjects or units.</p>
        </div>
        <div class="card" onclick="location.href='practice_review.php';">
            <h4>Review Past Practice</h4>
            <p>Revisit your previously attempted practice questions.</p>
        </div>
        <div class="card" onclick="location.href='practice_suggestions.php';">
            <h4>Smart Suggestions</h4>
            <p>See your weak areas and improve with suggestions.</p>
        </div>
    </div>
</div>


<footer>
    &copy; <?php echo date("Y"); ?> BCA MCQ Exam | For support contact admin
</footer>

</body>
</html>
