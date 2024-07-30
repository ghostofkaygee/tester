<?php
// Include the database connection script
include 'connection.php';

// Process registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs (you should add more validation as needed)
    $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
    $password = $_POST["password"]; // Plain-text password
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

    // Hash the password using PHP's built-in password_hash() function
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into database
    $query = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username, $hashed_password, $email]);

    // Check if insertion was successful
    if ($stmt->rowCount() > 0) {
        echo "Registration successful!";
    } else {
        echo "Registration failed.";
    }
}

?>
