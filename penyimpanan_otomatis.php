<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['submit'])) {
    $auto_savings_amount = $_POST['auto_savings_amount'];

    $user_id = 1;
    $timestamp = date('Y-m-d H:i:s');

    header('Location: dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Penyimpanan Otomatis</title>
</head>
<body>
    <h2>Penyimpanan Otomatis</h2>
    <form action="penyimpanan_otomatis.php" method="post">
        <label for="auto_savings_amount">Jumlah Penyimpanan Otomatis:</label>
        <input type="number" name="auto_savings_amount" required>
        <br>
        <input type="submit" name="submit" value="Simpan Otomatis">
    </form>
</body>
</html>
