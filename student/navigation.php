<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$student_name = $_SESSION['student_name'] ?? 'Student';
?>

<style>
    /* Remove all margins/paddings outside the header */
    body {
        margin: 0;
        padding: 0;
    }

    header {
        background-color: #007bff;
        color: white;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 0;
        border-radius: 0;
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
</style>

<header>
    <h2>Welcome, <?php echo htmlspecialchars($student_name); ?></h2>
    <nav>
        <a href="student_home.php">Home</a>
        <a href="start_exam.php">Start Exam</a>
        <a href="student_result_history.php">My Results</a>
        <a href="profile.php">Profile</a>
        <a href="studentLogout.php">Logout</a>
    </nav>
</header>
