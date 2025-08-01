<?php
session_start();
include '../db_config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer-master/src/PHPMailer.php';
require __DIR__ . '/PHPMailer-master/src/SMTP.php';
require __DIR__ . '/PHPMailer-master/src/Exception.php';

if (!isset($_SESSION['email']) || !isset($_SESSION['student_id'])) {
    echo "Session expired. Please login again.";
    exit;
}

$email = $_SESSION['email'];
$student_id = $_SESSION['student_id'];

// Fetch user full name (optional)
$stmt = $conn->prepare("SELECT full_name FROM students WHERE id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$stmt->bind_result($full_name);
$stmt->fetch();
$stmt->close();

// Generate and update new OTP
$otp = rand(100000, 999999);
$_SESSION['otp'] = $otp;
$_SESSION['otp_time'] = time();

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'ss4246810@gmail.com';
    $mail->Password = 'tavdvlvoysoxswbo';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('your_gmail@gmail.com', 'BCA MCQ EXAM');
    $mail->addAddress($email, $full_name);
    $mail->isHTML(true);
    $mail->Subject = 'Resent OTP';
    $mail->Body = "<h3>Your new OTP is: <strong>$otp</strong></h3><p>Valid for 1 minute.</p>";

    $mail->send();
    echo "OTP resent";
} catch (Exception $e) {
    echo "Mailer Error: " . $mail->ErrorInfo;
}
?>
