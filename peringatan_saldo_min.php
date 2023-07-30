<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$user_id = 1; 
$balance = 1000.00; 
$minimum_balance = 500.00;

if ($balance <= $minimum_balance) {
    $warning_message = "Peringatan: Saldo Anda mendekati atau mencapai batas minimum.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Peringatan Batas Saldo Minimum</title>
</head>
<body>
    <h2>Peringatan Batas Saldo Minimum</h2>
    <?php if (isset($warning_message)) { ?>
        <p style="color: red;"><?php echo $warning_message; ?></p>
    <?php } ?>
</body>
</html>
