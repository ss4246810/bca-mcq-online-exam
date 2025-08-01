<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - BCA MCQ Online Exam</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
    </header>
    <nav>
        <ul>
            <li><a href="/bca_mcq_exam/homePage.php">Home</a></li>
            <li><a href="#add-questions">Add Questions</a></li>
            <li><a href="#manage-exams">Manage Exams</a></li>
        </ul>
    </nav>
    <section id="add-questions" class="dashboard">
        <h2>Add MCQ Questions</h2>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" required><br><br>
            
            <label for="question">Question:</label>
            <textarea id="question" name="question" required></textarea><br><br>
            
            <label for="option1">Option 1:</label>
            <input type="text" id="option1" name="option1" required><br><br>
            
            <label for="option2">Option 2:</label>
            <input type="text" id="option2" name="option2" required><br><br>
            
            <label for="option3">Option 3:</label>
            <input type="text" id="option3" name="option3" required><br><br>
            
            <label for="option4">Option 4:</label>
            <input type="text" id="option4" name="option4" required><br><br>
            
            <label for="correct">Correct Answer:</label>
            <select id="correct" name="correct" required>
                <option value="option1">Option 1</option>
                <option value="option2">Option 2</option>
                <option value="option3">Option 3</option>
                <option value="option4">Option 4</option>
            </select><br><br>
            
            <label for="image">Upload Image:</label>
            <input type="file" id="image" name="image"><br><br>
            
            <label for="audio">Upload Audio:</label>
            <input type="file" id="audio" name="audio"><br><br>
            
            <label for="video">Upload Video:</label>
            <input type="file" id="video" name="video"><br><br>
            
            <button type="submit">Add Question</button>
        </form>
    </section>
    
    <section id="manage-exams" class="dashboard">
        <h2>Manage Exams</h2>
        <p>View and edit existing exams here.</p>
    </section>
</body>
</html>
