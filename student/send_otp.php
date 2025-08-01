<?php
session_start();
include '../db_config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer-master/src/PHPMailer.php';
require __DIR__ . '/PHPMailer-master/src/SMTP.php';
require __DIR__ . '/PHPMailer-master/src/Exception.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validate email and password presence
    if (empty($email) || empty($password)) {
        die("Email and password are required.");
    }

    // Check if user exists and password is correct
    $stmt = $conn->prepare("SELECT id, password, full_name FROM students WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        $stmt->close();
        die("Email not registered.");
    }

    $stmt->bind_result($id, $hashed_password, $full_name);
    $stmt->fetch();

    if (!password_verify($password, $hashed_password)) {
        $stmt->close();
        die("Incorrect password.");
    }
    $stmt->close();

    // Generate OTP (6 digit)
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_time'] = time();
    $_SESSION['email'] = $email;
    $_SESSION['student_id'] = $id;
    $_SESSION['student_name']=$full_name;
    

    // Create PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'ss4246810@gmail.com'; // Your Gmail address
        $mail->Password = 'tavdvlvoysoxswbo'; // Gmail app password (see below)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('your_gmail@gmail.com', 'BCA MCQ EXAM
');
        $mail->addAddress($email, $full_name);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP for Login';
        $mail->Body = "<h3>Your OTP is: <strong>$otp</strong></h3><p>Please use this OTP to complete your login.</p>";

        $mail->send();

        // Redirect to OTP verify page
        header("Location: verify_otp.php");
        exit();

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid request method.";
}
?>
