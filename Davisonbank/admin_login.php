<?php
session_start();
require_once 'connection.php'; // Ensure this path is correct

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch the user from the database using prepared statements
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND role = 'admin'");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $hashedPassword = $user['password'];

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            // Password is correct, create a session for the admin user
            $_SESSION['admin_username'] = $username;
            header("Location: admin_dashboard.php");
            exit;
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "Invalid username or not an admin.";
    }
}
?>
