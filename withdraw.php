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

    if ($amount > 0) {
        $type = 'withdraw';
        $recipient = null; 

        $insert_query = "INSERT INTO transaction_history (user_id, type, amount, recipient) VALUES ($user_id, '$type', $amount, '$recipient')";
        $result = $connection->query($insert_query);

        if ($result) {
            header('Location: dashboard.php');
            exit();
        } else {
            echo "Error: " . $connection->error;
        }
    } else {
        echo "Jumlah withdraw tidak valid.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Withdraw</title>
</head>
<body>
    <h2>Withdraw</h2>
    <form action="withdraw.php" method="post">
        <label for="amount">Jumlah Penarikan:</label>
        <input type="number" name="amount" required>
        <br>
        <input type="submit" name="submit" value="Withdraw">
    </form>
</body>
</html>