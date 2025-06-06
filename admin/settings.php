<?php
include_once __DIR__ . '/../includes/auth.php';
require_admin_login();

$configFile = __DIR__ . '/../config/settings.json';

$settings = ['delay' => 2, 'max_requests' => 10];
if (file_exists($configFile)) {
    $settings = json_decode(file_get_contents($configFile), true) ?: $settings;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $delay = intval($_POST['delay']);
    $max_requests = intval($_POST['max_requests']);

    if ($delay >= 0 && $max_requests > 0) {
        $settings = ['delay' => $delay, 'max_requests' => $max_requests];
        file_put_contents($configFile, json_encode($settings, JSON_PRETTY_PRINT));
        $message = 'Settings saved';
    } else {
        $message = 'Invalid values';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Settings</title>
<link rel="stylesheet" href="style.css" />
</head>
<body>
<div class="container">
    <h1>Settings</h1>

    <?php if ($message): ?>
        <p class="message"><?=htmlspecialchars($message)?></p>
    <?php endif; ?>

    <form method="post">
        <label>Request Delay (seconds):<br>
            <input type="number" name="delay" min="0" value="<?=htmlspecialchars($settings['delay'])?>" required>
        </label><br><br>
        <label>Max Requests per Run:<br>
            <input type="number" name="max_requests" min="1" value="<?=htmlspecialchars($settings['max_requests'])?>" required>
        </label><br><br>
        <button type="submit">Save Settings</button>
    </form>

    <p><a href="dashboard.php">Back to Dashboard</a></p>
</div>
</body>
</html>