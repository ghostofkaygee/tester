<?php
session_start();
require_once 'connection.php';

// Check if the admin user is logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.html");
    exit;
}

$query = "SELECT * FROM external_transfers WHERE status = 'Pending'";
$stmt = $pdo->prepare($query);
$stmt->execute();
$pending_transfers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage External Transfers</title>
    <link rel="stylesheet" href="stylesa.css">
</head>
<body>
    <header class="header">
        <div class="logo">Bank Admin</div>
        <nav class="nav">
            <ul>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="admin_external_transfers.php">Manage External Transfers</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Pending External Transfers</h2>
        <table>
            <thead>
                <tr>
                    <th>Recipient Name</th>
                    <th>Recipient Bank</th>
                    <th>Account Number</th>
                    <th>SWIFT Code</th>
                    <th>Amount</th>
                    <th>Notes</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pending_transfers as $transfer) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($transfer['recipient_name']); ?></td>
                    <td><?php echo htmlspecialchars($transfer['recipient_bank']); ?></td>
                    <td><?php echo htmlspecialchars($transfer['account_number']); ?></td>
                    <td><?php echo htmlspecialchars($transfer['swift_code']); ?></td>
                    <td><?php echo htmlspecialchars($transfer['amount']); ?></td>
                    <td><?php echo htmlspecialchars($transfer['notes']); ?></td>
                    <td>
                        <form action="process_admin_transfer.php" method="POST">
                            <input type="hidden" name="transfer_id" value="<?php echo $transfer['id']; ?>">
                            <input type="hidden" name="transfer_type" value="external">
                            <button type="submit" name="action" value="approve">Approve</button>
                            <button type="submit" name="action" value="reject">Reject</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
