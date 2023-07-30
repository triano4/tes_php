<!-- deposit.php -->
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
        $type = 'deposit';
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
        echo "Jumlah deposit tidak valid.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Deposit</title>
</head>
<body>
    <h2>Deposit</h2>
    <form action="deposit.php" method="post">
        <label for="amount">Jumlah Deposit:</label>
        <input type="number" name="amount" required>
        <br>
        <input type="submit" name="submit" value="Deposit">
    </form>
</body>
</html>