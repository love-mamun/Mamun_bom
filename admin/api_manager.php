<?php
include_once __DIR__ . '/../includes/auth.php';
require_admin_login();

$apiFile = __DIR__ . '/../api/apis.json';

$apis = json_decode(file_get_contents($apiFile), true) ?: [];

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $name = trim($_POST['name']);
        $url = trim($_POST['url']);
        if ($name && $url && strpos($url, '{{phone}}') !== false) {
            $apis[] = ['name' => $name, 'url' => $url];
            file_put_contents($apiFile, json_encode($apis, JSON_PRETTY_PRINT));
            $message = 'API added successfully';
        } else {
            $message = 'Name and URL (with {{phone}}) required';
        }
    } elseif (isset($_POST['delete'])) {
        $index = intval($_POST['delete']);
        if (isset($apis[$index])) {
            array_splice($apis, $index, 1);
            file_put_contents($apiFile, json_encode($apis, JSON_PRETTY_PRINT));
            $message = 'API deleted successfully';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Manage APIs</title>
<link rel="stylesheet" href="style.css" />
</head>
<body>
<div class="container">
    <h1>Manage APIs</h1>
    <?php if ($message): ?>
        <p class="message"><?=htmlspecialchars($message)?></p>
    <?php endif; ?>

    <h2>Add New API</h2>
    <form method="post">
        <label>Name:<br><input type="text" name="name" required></label><br><br>
        <label>URL (use {{phone}}):<br><input type="text" name="url" required></label><br><br>
        <button type="submit" name="add">Add API</button>
    </form>

    <h2>Existing APIs</h2>
    <table>
        <thead>
            <tr><th>#</th><th>Name</th><th>URL</th><th>Actions</th></tr>
        </thead>
        <tbody>
        <?php foreach ($apis as $i => $api): ?>
            <tr>
                <td><?= $i+1 ?></td>
                <td><?=htmlspecialchars($api['name'])?></td>
                <td><?=htmlspecialchars($api['url'])?></td>
                <td>
                    <form method="post" style="display:inline" onsubmit="return confirm('Delete this API?');">
                        <button type="submit" name="delete" value="<?=$i?>">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <p><a href="dashboard.php">Back to Dashboard</a></p>
</div>
</body>
</html>