<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BCA MCQ Online Exam</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>BCA MCQ Online Exam</h1>
    </header>
    <nav>
        <ul>
            <li><a href="admin/adminDashboard.php">Admin Dashboard</a></li>
            <li><a href="student/student_dummy_home.php">Student Dashboard</a></li>
        </ul>
    </nav>
    <section id="admin" class="dashboard">
        <h2>Admin Dashboard</h2>
        <p>Here, the admin can add subject-based MCQ questions along with images, audio, and videos.</p>
        <button onclick="location.href='admin_login.php'">Go to Admin Panel</button>
    </section>
    <section id="student" class="dashboard">
        <h2>Student Dashboard</h2>
        <p>Students can view subjects and take exams.</p>
        <button onclick="location.href='student/student_dummy_home.php'">Go to Student Panel</button>
    </section>
</body>
</html>
