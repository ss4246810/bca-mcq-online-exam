<?php
// student_register.php
session_start();
include '../db_config.php';

// Redirect if already logged in
if (isset($_SESSION['student_logged_in'])) {
    header("Location: student_home.php");
    exit();
}

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Server-side Validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters.";
    }
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM students WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors[] = "Email is already registered.";
        } else {
            $stmt = $conn->prepare("INSERT INTO students (full_name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $full_name, $email, $hashed_password);

            if ($stmt->execute()) {
                $success = "Registration successful. You can now <a href='student_login.php'>login</a>.";
            } else {
                $errors[] = "Error saving student.";
            }
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Registration</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            background: #fff;
            padding: 30px;
            max-width: 400px;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            padding: 10px;
            margin-top: 15px;
            background: #007bff;
            color: white;
            border: none;
            width: 100%;
            border-radius: 5px;
            font-weight: bold;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
        .success {
            color: green;
            margin-bottom: 10px;
        }
        small {
            font-size: 12px;
            color: gray;
            display: block;
            margin-bottom: 5px;
        }
        .login-link {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
        }
        .login-link a {
            color: #007bff;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Student Registration</h2>

    <?php if (!empty($errors)): ?>
        <div class="error"><?php echo implode('<br>', $errors); ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST" onsubmit="return validateForm();">
        <label>Full Name:</label>
        <input type="text" name="full_name" required>

        <label>Email:</label>
        <input type="email" name="email" id="email" required>
        <small id="emailHelp">We'll validate your email format.</small>

        <label>Password:</label>
        <input type="password" name="password" id="password" required>
        <small id="strengthText">min 8 chars, use A-Z, a-z, 0-9 & symbols (!@#$%)</small>

        <label>Confirm Password:</label>
        <input type="password" name="confirm_password" required>

        <button type="submit">Register</button>
    </form>

    <div class="login-link">
        Already have an account? <a href="student_login.php">Login here</a>.
    </div>
</div>

<script>
    const password = document.getElementById('password');
    const strengthText = document.getElementById('strengthText');
    const email = document.getElementById('email');
    const emailHelp = document.getElementById('emailHelp');

    // Password strength
    password.addEventListener('input', () => {
        const val = password.value;
        let strength = 0;
        if (val.length >= 8) strength++;
        if (/[a-z]/.test(val)) strength++;
        if (/[A-Z]/.test(val)) strength++;
        if (/\d/.test(val)) strength++;
        if (/[^A-Za-z0-9]/.test(val)) strength++;

        if (strength <= 2) {
            strengthText.textContent = "Weak password ❌";
            strengthText.style.color = "red";
        } else if (strength <= 4) {
            strengthText.textContent = "Moderate password ⚠️";
            strengthText.style.color = "orange";
        } else {
            strengthText.textContent = "Strong password ✅";
            strengthText.style.color = "green";
        }
    });

    // Email validation
    email.addEventListener('input', () => {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (emailPattern.test(email.value)) {
            emailHelp.textContent = "Valid email ✅";
            emailHelp.style.color = "green";
        } else {
            emailHelp.textContent = "Invalid email ❌";
            emailHelp.style.color = "red";
        }
    });

    function validateForm() {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email.value)) {
            alert("Please enter a valid email.");
            return false;
        }
        return true;
    }
</script>

</body>
</html>
