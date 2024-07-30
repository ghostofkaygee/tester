<?php
// Include the database connection script
include 'connection.php';

session_start(); // Start session for storing user information

// Process login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs (you should add more validation as needed)
    $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
    $password = $_POST["password"]; // Plain-text password

    // Fetch user data from database
    $query = "SELECT user_id, username, password FROM users WHERE username = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Verify hashed password
        if (password_verify($password, $user['password'])) {
            // Passwords match, login successful
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            // Redirect to a logged-in area or display a success message
            header("Location: dashboard.php"); // Replace with your dashboard URL
            exit(); // Ensure that script execution stops after redirection
        } else {
            // Passwords do not match
            echo "Incorrect password.";
        }
    } else {
        // Username not found
        echo "Username not found.";
    }
}
?>
