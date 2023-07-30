<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$user_id = 1; 
$expenses = array(); 
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kategori Pengeluaran</title>
</head>
<body>
    <h2>Kategori Pengeluaran</h2>
    <form action="kategori_pengeluaran.php" method="post">
        <label for="category">Kategori:</label>
        <input type="text" name="category" required>
        <br>
        <label for="amount">Jumlah Pengeluaran:</label>
        <input type="number" name="amount" required>
        <br>
        <input type="submit" name="submit" value="Tambah Pengeluaran">
    </form>

    <h3>Daftar Pengeluaran</h3>
    <table>
        <tr>
            <th>Kategori</th>
            <th>Jumlah Pengeluaran</th>
        </tr>
        <?php foreach ($expenses as $expense) { ?>
            <tr>
                <td><?php echo $expense['category']; ?></td>
                <td><?php echo $expense['amount']; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
