<?php
session_start();
require_once 'connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $recipient_name = $_POST['recipient_name'];
    $recipient_bank = $_POST['recipient_bank'];
    $account_number = $_POST['account_number'];
    $swift_code = $_POST['swift_code'];
    $amount = $_POST['amount'];
    $notes = $_POST['notes'];

    // Validate form data (server-side validation should be done here)

    // Insert data into the database
    $query = "INSERT INTO external_transfers (user_id, recipient_name, recipient_bank, account_number, swift_code, amount, notes) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $result = $stmt->execute([$user_id, $recipient_name, $recipient_bank, $account_number, $swift_code, $amount, $notes]);

    if ($result) {
        // Redirect upon successful insertion
        header("Location: transfer_requests.php");
        exit();
    } else {
        // Handle insertion failure
        $error = "Failed to submit transfer request. Please try again.";
    }
}
?>
