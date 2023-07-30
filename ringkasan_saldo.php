<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

require_once 'config.php'; 
$user_id = $_SESSION['user_id']; 
$query = "SELECT balance FROM users WHERE id = $user_id";
$result = $connection->query($query);

$initial_balance = 0.00;

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $initial_balance = $row['balance'];
}

$query = "SELECT * FROM transaction_history WHERE user_id = $user_id ORDER BY timestamp";
$result = $connection->query($query);

$transaction_list = array();
$current_balance = $initial_balance;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $transaction_list[] = $row;
        if ($row['type'] == 'deposit') {
            $current_balance += $row['amount'];
        } elseif ($row['type'] == 'withdraw') {
            $current_balance -= $row['amount'];
        } elseif ($row['type'] == 'transfer' && $row['user_id'] == $user_id) {
            $current_balance -= $row['amount'];
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ringkasan Saldo</title>
</head>
<body>
    <h2>Ringkasan Saldo</h2>
    <p>Saldo Awal Bulan: <?php echo $initial_balance; ?></p>
    <p>Saldo Akhir Bulan: <?php echo $current_balance; ?></p>
    <h3>Daftar Transaksi</h3>
    <table>
        <tr>
            <th>Tanggal</th>
            <th>Jenis Transaksi</th>
            <th>Jumlah</th>
        </tr>
        <?php foreach ($transaction_list as $transaction) { ?>
            <tr>
                <td><?php echo $transaction['timestamp']; ?></td>
                <td><?php echo ucfirst($transaction['type']); ?></td>
                <td><?php echo $transaction['amount']; ?></td>
            </tr>
        <?php } ?>
    </table>
    <h3>Action:</h3>
    <ul>
        <li><a href="dashboard.php">Kembali</a></li>
    </ul>
</body>
</html>