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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Proyeksi Tabungan</title>
</head>
<body>
    <h2>Proyeksi Tabungan</h2>
    <?php
    $projection_months = 6;
    $projection_data = array();

    for ($i = 1; $i <= $projection_months; $i++) {
        $projected_balance = $initial_balance;

        $query = "SELECT SUM(amount) as total_income FROM transaction_history WHERE user_id = $user_id AND type = 'deposit' AND MONTH(timestamp) = MONTH(CURRENT_DATE - INTERVAL ($projection_months - $i) MONTH)";
        $result = $connection->query($query);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $projected_balance += $row['total_income'];
        }

        $projection_data[] = $projected_balance;
    }
    ?>

    <h3>Proyeksi Tabungan Selama <?php echo $projection_months; ?> Bulan</h3>
    <ul>
        <?php for ($i = 1; $i <= $projection_months; $i++) { ?>
            <li>Bulan ke-<?php echo $i; ?>: <?php echo $projection_data[$i - 1]; ?></li>
        <?php } ?>
    </ul>
    <h3>Action:</h3>
    <ul>
        <li><a href="dashboard.php">Kembali</a></li>
    </ul>
</body>
</html>