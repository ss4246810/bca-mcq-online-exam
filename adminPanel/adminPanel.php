<?php

include '../db_config.php';

session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - BCA MCQ Online Exam</title>
    <link rel="stylesheet" href="admin_styles.css">
</head>
<body>
    <!-- <header>
        <h1>Admin Panel</h1>
        <a href="/bca_mcq_exam/logout.php" class="logout-button">Logout</a>

    </header> -->
       <?php include 'admin_nav.php'; ?>
    
    
    <section id="manage-questions" class="panel-section">
        <h2>Manage Questions</h2>
        <p>View, edit, or delete existing MCQ questions here.</p>
    </section>
    <br>
    <section id="manage-questions" class="panel-section">
        <h2>Add Questions</h2>
        <p>You can add multiple subject mcq question with image,audio,video upload feature .</p>
    </section>
</body>
</html>
