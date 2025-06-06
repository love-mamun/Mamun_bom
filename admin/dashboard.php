<?php
include_once __DIR__ . '/../includes/auth.php';
require_admin_login();

$logDir = __DIR__ . '/../api/logs';
$logFile = $logDir . '/' . date('Y-m-d') . '.log';

$totalCalls = 0;
$successCount = 0;
$failCount = 0;

if (file_exists($logFile)) {
    $lines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $totalCalls++;
        if (strpos($line, 'SUCCESS') !== false) $successCount++;
        else $failCount++;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Admin Dashboard</title>
<link rel="stylesheet" href="style.css" />
</head>
<body>
<div class="container">
    <h1>Admin Dashboard</h1>
    <p>Total API Calls Today: <?=$totalCalls?></p>
    <p>Success: <?=$successCount?></p>
    <p>Failure: <?=$failCount?></p>

    <nav>
        <a href="api_manager.php">Manage APIs</a> |
        <a href="settings.php">Settings</a> |
        <a href="logs.php">View Logs</a> |
        <a href="logout.php">Logout</a>
    </nav>
</div>
</body>
</html>