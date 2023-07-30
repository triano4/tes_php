<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

require_once 'config.php'; 

$user_id = $_SESSION['user_id']; 


$query = "SELECT * FROM transaction_history WHERE user_id = $user_id ORDER BY timestamp";
$result = $connection->query($query);

$transaction_list = array();
$current_balance = 0.00;

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


$labels = array();
$balances = array();
$balance = $current_balance;

foreach ($transaction_list as $transaction) {
    $labels[] = date('Y-m-d', strtotime($transaction['timestamp']));
    if ($transaction['type'] == 'deposit') {
        $balance += $transaction['amount'];
    } elseif ($transaction['type'] == 'withdraw' || ($transaction['type'] == 'transfer' && $transaction['user_id'] == $user_id)) {
        $balance -= $transaction['amount'];
    }
    $balances[] = $balance;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Grafik Tabungan</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h2>Grafik Tabungan</h2>
    <canvas id="myChart"></canvas>

    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Saldo Tabungan',
                    data: <?php echo json_encode($balances); ?>,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'day'
                        }
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>