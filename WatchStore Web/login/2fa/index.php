<?php
include("../db.php");
ob_start();
session_start();

$message = '';

if (!isset($_SESSION['username']) || !isset($_SESSION['two_fa']) || $_SESSION['two_fa'] !== 'false') {
    header('Location: /login');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user = $_POST['username'] ?? '';
    $otp = $_POST['otp'] ?? '';

    if (strlen($otp) === 6 && ctype_digit($otp)) {
        $_SESSION['username'] = $user;
        header("Location: /");
        exit;
    } else {
        $message = "Invalid OTP!";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>2FA Verification - WatchStore DVWA</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-box {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 30px;
            border-radius: 8px;
            width: 350px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .login-box h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        .login-box input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .login-box button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .login-box .message {
            text-align: center;
            color: red;
            margin-top: 10px;
        }

        .hint {
            font-size: 12px;
            color: #888;
            margin-top: 15px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="login-box">
    <center>
            <P><?php echo $_POST['username'];  ?></P>
    </center>
    <h2>Login success. Complete the 2FA Authentication below.</h2>
    <form method="POST">
        <input name="otp" placeholder="OTP Recived from your email" required />
        <button type="submit">Verify</button>
    </form>
    <?php if ($message): ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>
    <div class="hint">
        
    </div>
</div>

</body>
</html>
