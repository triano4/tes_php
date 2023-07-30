<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id']; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $recipient = $_POST['recipient']; 

    if ($amount > 0) {
        $type = 'transfer';

        $insert_query = "INSERT INTO transaction_history (user_id, type, amount, recipient) VALUES ($user_id, '$type', $amount, '$recipient')";
        $result = $connection->query($insert_query);

        if ($result) {
            header('Location: dashboard.php');
            exit();
        } else {
            echo "Error: " . $connection->error;
        }
    } else {
        echo "Jumlah transfer tidak valid.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transfer</title>
</head>
<body>
    <h2>Transfer</h2>
    <form action="transfer.php" method="post">
        <label for="amount">Jumlah Transfer:</label>
        <input type="number" name="amount" required>
        <br>
        <label for="recipient">Nomor Rekening Penerima:</label>
        <input type="text" name="recipient" required>
        <br>
        <input type="submit" name="submit" value="Transfer">
    </form>
</body>
</html>