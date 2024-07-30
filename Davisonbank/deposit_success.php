<?php
session_start();
require_once 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Deposit Successful</title>
    <link rel="stylesheet" href="stylesde.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="settings.php">Settings</a></li>
                <li><a href="deposit.php">Deposit</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <h2>Deposit Successful</h2>
        <p>Your check deposit has been successfully submitted. Please wait for your deposit to be approved before reflection.</p>
        <a href="dashboard.php">Go to Dashboard</a>
    </div>
</body>
</html>
