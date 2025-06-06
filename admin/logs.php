<?php
include_once __DIR__ . '/../includes/auth.php';
require_admin_login();

$logDir = __DIR__ . '/../api/logs';

$files = array_diff(scandir($logDir, SCANDIR_SORT_DESCENDING), ['.', '..']);

$viewFile = $_GET['file'] ?? '';

if ($viewFile && strpos($viewFile, '..') === false && file_exists("$logDir/$viewFile")) {
    $content = file_get_contents("$logDir/$viewFile");
} else {
    $content = '';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>View Logs</title>
<link rel="stylesheet" href="style.css" />
<style>
.log-content {
    background: #000;
    color: #0f0;
    padding: 15px;
    white-space: pre-wrap;
    font-family: monospace;
    max-height: 500px;
    overflow-y: scroll;
}
</style>
</head>
<body>
<div class="container">
    <h1>API Logs</h1>

    <h2>Available Logs</h2>
    <ul>
        <?php foreach ($files as $file): ?>
            <li><a href="?file=<?=urlencode($file)?>"><?=htmlspecialchars($file)?></a></li>
        <?php endforeach; ?>
    </ul>

    <?php if ($content): ?>
        <h2>Contents of <?=htmlspecialchars($viewFile)?></h2>
        <div class="log-content"><?=htmlspecialchars($content)?></div>
    <?php endif; ?>

    <p><a href="dashboard.php">Back to Dashboard</a></p>
</div>
</body>
</html>