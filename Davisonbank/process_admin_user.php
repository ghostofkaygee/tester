<?php
session_start();
require_once 'connection.php';

// Check if the admin user is logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.html");
    exit;
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $checkingbalance = $_POST['checkingbalance'];
    $savingbalance = $_POST['savingsbalance'];
    $investmentbalance = $_POST['Investmentbalance'];
    $deposits = $_POST['deposits'];
    $transfers = $_POST['transfers'];
    $failed = $_POST['failed'];
    $reversed = $_POST['reversed'];
    $dates = $_POST['dates'];
    $descriptions = $_POST['descriptions'];
    $reason = $_POST['reason'];
    $recipient = $_POST['recipient'];
    $transaction_id = $_POST['transaction_id'];

    try {
        // Prepare update statement
        $stmt = $pdo->prepare('
            UPDATE users SET
                password = :password,
                email = :email,
                checkingbalance = :checkingbalance,
                savingsbalance = :savingsbalance,
                Investmentbalance = :Investmentbalance,
                deposits = :deposits,
                transfers = :transfers,
                failed = :failed,
                reversed = :reversed,
                dates = :dates,
                descriptions = :descriptions,
                reason = :reason,
                recipient = :recipient,
                transaction_id = :transaction_id
            WHERE user_id = :user_id
        ');

        // Bind parameters
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':checkingbalance', $checkingbalance);
        $stmt->bindParam(':savingsbalance', $savingbalance);
        $stmt->bindParam(':Investmentbalance', $investmentbalance);
        $stmt->bindParam(':deposits', $deposits);
        $stmt->bindParam(':transfers', $transfers);
        $stmt->bindParam(':failed', $failed);
        $stmt->bindParam(':reversed', $reversed);
        $stmt->bindParam(':dates', $dates);
        $stmt->bindParam(':descriptions', $descriptions);
        $stmt->bindParam(':reason', $reason);
        $stmt->bindParam(':recipient', $recipient);
        $stmt->bindParam(':transaction_id', $transaction_id);

        // Execute statement
        $stmt->execute();

        // Redirect back to manage users page with success message
        header('Location: admin_manage_users.php?update =success');
        exit;
    } catch (PDOException $e) {
        // Handle error
        echo 'Error: ' . $e->getMessage();
    }
} else {
    // Not a POST request
    header('Location: admin_manage_users.php');
    exit;
}
?>
