<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

require_once 'config.php'; // Sertakan file konfigurasi koneksi

$user_id = $_SESSION['user_id']; // Sesuaikan dengan session ID pengguna yang telah disimpan saat login

// Ambil data pengeluaran dari database untuk pengguna yang sedang login
$query = "SELECT * FROM transaction_history WHERE user_id = $user_id AND type = 'withdraw' ORDER BY timestamp DESC";
$result = $connection->query($query);

$expense_list = array();
$total_expenses = 0.00;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $expense_list[] = $row;
        $total_expenses += $row['amount'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Rekapitulasi Pengeluaran</title>
</head>
<body>
    <h2>Rekapitulasi Pengeluaran</h2>
    <table>
        <tr>
            <th>Tanggal</th>
            <th>Jumlah Pengeluaran</th>
        </tr>
        <?php foreach ($expense_list as $expense) { ?>
            <tr>
                <td><?php echo $expense['timestamp']; ?></td>
                <td><?php echo $expense['amount']; ?></td>
            </tr>
        <?php } ?>
        <tr>
            <th>Total Pengeluaran</th>
            <td><?php echo $total_expenses; ?></td>
        </tr>
    </table>
    <h3>Action:</h3>
    <ul>
        <li><a href="dashboard.php">Kembali</a></li>
    </ul>
</body>
</html>