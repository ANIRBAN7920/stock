<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $enteredOtp = $_POST['otp'];

    if ($enteredOtp == $_SESSION['otp']) {
        echo "Registration successful!";
        session_destroy();
    } else {
        echo "Invalid OTP. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verify OTP</title>
</head>
<body>
    <h1>Verify OTP</h1>
    <form method="POST">
        <label for="otp">Enter OTP:</label>
        <input type="number" id="otp" name="otp" required>
        <button type="submit">Verify</button>
    </form>
</body>
</html>
