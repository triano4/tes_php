<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}


$user_id = $_SESSION['user_id']; 
$query = "SELECT id, balance FROM users WHERE id = $user_id LIMIT 1";
$result = $connection->query($query);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $user_balance = $row['balance'];
} else {
    
    die("Data pengguna tidak ditemukan.");
}


$recent_transactions = array();

$query = "SELECT * FROM transaction_history WHERE user_id = $user_id ORDER BY timestamp DESC LIMIT 5";
$result = $connection->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $recent_transactions[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mini ATM</title>
</head>
<body>
    <h2>Selamat datang, <?php echo $_SESSION['username']; ?>!</h2>
    <h3>Ringkasan Saldo</h3>
    <?php
    $ending_balance = 0;
    foreach ($recent_transactions as $transaction) {
        if ($transaction['type'] == 'deposit') {
            $ending_balance += $transaction['amount'];
        } elseif ($transaction['type'] == 'withdraw') {
            $ending_balance -= $transaction['amount'];
        } elseif ($transaction['type'] == 'transfer') {
            
            if ($transaction['user_id'] == $user_id) {
                $ending_balance -= $transaction['amount'];
            }
        }
    }
    ?>

    <p>Saldo Akhir Bulan: <?php echo $ending_balance; ?></p>

    <h3>Transaksi Terakhir</h3>
    <ul>
        <?php foreach ($recent_transactions as $transaction) { ?>
            <li><?php echo $transaction['type']; ?> - <?php echo $transaction['amount']; ?></li>
        <?php } ?>
    </ul>

    <h4>Action:</h4>
    <ul>
        <li><a href="deposit.php">Setor</a></li>
        <li><a href="withdraw.php">Tarik</a></li>
        <li><a href="transfer.php">Transfer</a></li>
        <li><a href="ringkasan_saldo.php">Cek Saldo</a></li>
        <li><a href="rekap_pengeluaran.php">Rekap Pengeluaran</a></li>
        <li><a href="proyeksi.php">Proyeksi Tabungan</a></li>
    </ul>
</body>
</html>