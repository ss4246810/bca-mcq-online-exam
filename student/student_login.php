<?php
// Step 1: student_login.php (Form where user enters their email and password)
session_start();
if (isset($_SESSION['student_logged_in'])) {
    header("Location: student_home.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        input[type=email],
        input[type=password],
        button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }
        small {
            display: block;
            margin-top: 5px;
            font-size: 12px;
            color: gray;
        }
        .register-link {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
        }
        .register-link a {
            color: #007bff;
            text-decoration: none;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Student Login</h2>
        <form method="POST" action="send_otp.php">
            <label for="email">Enter your Email:</label>
            <input type="email" name="email" id="email" required>
            <small id="emailHelp">We’ll send an OTP to this email</small>

            <label for="password">Enter your Password:</label>
            <input type="password" name="password" required>
            <small id="passwordHelp">min 8 chars, use A-Z, a-z, 0-9 & symbols (!@#$%)</small>

            <button type="submit">Send OTP</button>
             <div class="register-link">
        Don't have an account? <a href="student_register.php">Register here</a>.
    </div>
        </form>
    </div>

    <script>
        const passwordInput = document.querySelector('input[name="password"]');
        const helpText = document.getElementById('passwordHelp');

        passwordInput.addEventListener('input', () => {
            const password = passwordInput.value;
            let strength = 0;

            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/\d/.test(password)) strength++;
            if (/[!@#$%^&*]/.test(password)) strength++;

            if (strength <= 2) {
                helpText.textContent = "Weak password ❌";
                helpText.style.color = "red";
            } else if (strength === 3 || strength === 4) {
                helpText.textContent = "Moderate password ⚠️";
                helpText.style.color = "orange";
            } else {
                helpText.textContent = "Strong password ✅";
                helpText.style.color = "green";
            }
        });

        // Email validation
        const emailInput = document.getElementById('email');
        const emailHelp = document.getElementById('emailHelp');

        emailInput.addEventListener('input', () => {
            const email = emailInput.value;
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!regex.test(email)) {
                emailHelp.textContent = "Invalid email format ❌";
                emailHelp.style.color = "red";
            } else {
                emailHelp.textContent = "Valid email format ✅";
                emailHelp.style.color = "green";
            }
        });

        // Prevent form submission if email is invalid
        const form = document.querySelector("form");
        form.addEventListener("submit", function(e) {
            const email = emailInput.value;
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                e.preventDefault();
                alert("Please enter a valid email address.");
                emailInput.focus();
            }
        });
    </script>
</body>
</html>
