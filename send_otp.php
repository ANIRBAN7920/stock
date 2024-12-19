<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$email = $_SESSION['email'] ?? '';
$otp = $_SESSION['otp'] ?? '';

if ($email && $otp) {
    $mail = new PHPMailer(true);

    try {
        // // Enable debugging
        // $mail->SMTPDebug = 3;
        // $mail->Debugoutput = 'html';
    
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'anid2547@gmail.com'; // Your Gmail address
        $mail->Password = 'plom etgw vdwy jhsi'; // App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use TLS encryption
        $mail->Port = 587; // TCP port to connect to
    
        // Recipients
        $mail->setFrom('anid2547@gmail.com', 'Your Name');
        $mail->addAddress($email); // Recipient email address
    
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body = "Your OTP is: <b>$otp</b>";
        $mail->AltBody = "Your OTP is: $otp";
    
        $mail->send();
        $_SESSION['otp_sent'] = true;
        echo "Message sent successfully!";
    } catch (Exception $e) {
        $_SESSION['otp_sent'] = false;
        echo "Mailer Error: {$mail->ErrorInfo}";
        error_log("Mailer Error: " . $mail->ErrorInfo);
    }    
} else {
    $_SESSION['otp_sent'] = false;
}
