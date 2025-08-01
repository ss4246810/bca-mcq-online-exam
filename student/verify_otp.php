<?php
session_start();

if (!isset($_SESSION['otp']) || !isset($_SESSION['email']) || !isset($_SESSION['otp_time'])) {
    header("Location: student_login.php");
    exit();
}

$errors = [];
$success = "";
$expired = false;

// Check if OTP is expired (1 minute = 60 seconds)
if (time() - $_SESSION['otp_time'] > 60) {
    $errors[] = "OTP has expired. Please request a new one.";
    $expired = true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$expired) {
    $user_otp = trim($_POST['otp']);
    if ($user_otp == $_SESSION['otp']) {
        $_SESSION['student_logged_in'] = true;
        unset($_SESSION['otp'], $_SESSION['otp_time']);
        header("Location: student_home.php");
        exit();
    } else {
        $errors[] = "Invalid OTP. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Verify OTP</title>
    <style>
        body {
            font-family: Arial;
            background: #eef2f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .otp-box {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 100%;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #28a745;
            color: white;
            font-weight: bold;
        }
        .error { color: red; margin-bottom: 10px; }
        .success { color: green; margin-bottom: 10px; }
        .countdown { margin: 10px 0; font-weight: bold; }
        #resend-btn { display: none; background-color: #007bff; }
    </style>
</head>
<body>
    <div class="otp-box">
        <h2>Enter OTP</h2>

        <?php if (!empty($errors)): ?>
            <div class="error"><?= implode('<br>', $errors) ?></div>
        <?php endif; ?>

        <?php if (!$expired): ?>
        <form method="POST">
            <label>Enter the 6-digit OTP sent to your email:</label>
            <input type="number" name="otp" required maxlength="6">
            <div class="countdown">OTP expires in: <span id="timer">60</span> seconds</div>
            <button type="submit">Verify OTP</button>
        </form>
        <?php endif; ?>

        <button id="resend-btn" onclick="resendOtp()">Resend OTP</button>
        <div id="resend-status"></div>
    </div>

    <script>
        let timeLeft = 60;
        const timerSpan = document.getElementById("timer");
        const resendBtn = document.getElementById("resend-btn");
        const resendStatus = document.getElementById("resend-status");

        const countdown = setInterval(() => {
            timeLeft--;
            timerSpan.textContent = timeLeft;
            if (timeLeft <= 0) {
                clearInterval(countdown);
                resendBtn.style.display = "block";
                document.querySelector('.countdown').style.display = "none";
            }
        }, 1000);

        function resendOtp() {
            fetch("resend_otp.php")
                .then(res => res.text())
                .then(data => {
                    resendStatus.textContent = data;
                    resendBtn.style.display = "none";
                    timeLeft = 60;
                    timerSpan.textContent = timeLeft;
                    document.querySelector('.countdown').style.display = "block";
                    resendStatus.style.color = "green";

                    setTimeout(() => { resendStatus.textContent = ''; }, 3000);

                    // Restart countdown
                    countdownRestart();
                });
        }

        function countdownRestart() {
            const newCountdown = setInterval(() => {
                timeLeft--;
                timerSpan.textContent = timeLeft;
                if (timeLeft <= 0) {
                    clearInterval(newCountdown);
                    resendBtn.style.display = "block";
                    document.querySelector('.countdown').style.display = "none";
                }
            }, 1000);
        }
    </script>
</body>
</html>
