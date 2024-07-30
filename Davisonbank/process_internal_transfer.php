<?php
session_start();
require_once 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recipient_username = $_POST['recipient_username'];
    $amount = $_POST['amount'];
    $notes = $_POST['notes'];

    // Validate form data (server-side validation should be done here)

    // Check if recipient username exists
    $query = "SELECT user_id FROM users WHERE username = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$recipient_username]);
    $recipient = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($recipient) {
        $recipient_user_id = $recipient['user_id'];

        // Insert data into the database
        $query = "INSERT INTO internal_transfers (user_id, recipient_user_id, amount, notes, status) VALUES (?, ?, ?, ?, 'Pending')";
        $stmt = $pdo->prepare($query);
        $result = $stmt->execute([$user_id, $recipient_user_id, $amount, $notes]);

        if ($result) {
            // Redirect upon successful insertion
            header("Location: transfer_requests.php");
            exit();
        } else {
            // Handle insertion failure
            $error = "Failed to submit transfer request. Please try again.";
        }
    } else {
        $error = "Recipient username does not exist.";
    }
}
?>