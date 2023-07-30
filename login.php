<?php
session_start();
require_once 'config.php';

$error = 'error';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
    $password = $_POST['password'];

        $query = "SELECT id, password FROM users WHERE username = '$username' LIMIT 1";
    $result = $connection->query($query);

    if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
        $stored_password = $row['password'];

                if ($password === $stored_password) {
                        $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $result->num_rows ;
            header('Location: dashboard.php');
            exit();
        } else {
                        $error = "Username atau password salah.";
        }
    } else {
                $error = "Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if (isset($login_error)) { ?>
        <p style="color: red;"><?php echo $login_error; ?></p>
    <?php } ?>
    <form action="login.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <input type="submit" name="submit" value="Login">
    </form>
</body>
</html>