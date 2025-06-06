<?php
include_once __DIR__ . '/../includes/auth.php';

if (is_admin_logged_in()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Hardcoded credentials
    if ($username === 'admin' && $password === 'password123') {
        $_SESSION['admin_logged_in'] = true;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Invalid username or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Admin Login</title>
<link rel="stylesheet" href="style.css" />
</head>
<body>
<div class="login-container">
    <h2>Admin Login</h2>
    <?php if ($error): ?>
        <p class="error"><?=htmlspecialchars($error)?></p>
    <?php endif; ?>
    <form method="post">
        <label>Username:<br><input type="text" name="username" required></label><br><br>
        <label>Password:<br><input type="password" name="password" required></label><br><br>
        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>