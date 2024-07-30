<?php
session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.html");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

require_once 'connection.php';

try {
    $stmt = $pdo->prepare('UPDATE users SET password = ?, email = ?, checkingbalance = ?, savingbalance = ?, investmentbalance = ?, deposits = ?, transfers = ?, failed = ?, reversed = ?, dates = ?, descriptions = ?, reason = ?, recipient = ?, transaction_id = ? WHERE user_id = ?');
    $stmt->execute([
        $_POST['password'],
        $_POST['email'],
        $_POST['checkingbalance'],
        $_POST['savingbalance'],
        $_POST['investmentbalance'],
        $_POST['deposits'],
        $_POST['transfers'],
        $_POST['failed'],
        $_POST['reversed'],
        $_POST['dates'],
        $_POST['descriptions'],
        $_POST['reason'],
        $_POST['recipient'],
        $_POST['transaction_id'],
        $_POST['user_id']
    ]);

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => $e->getMessage()]);
}
?>
