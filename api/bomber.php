<?php
header('Content-Type: application/json');

$phone = $_GET['phone'] ?? '';
if (!$phone) {
    echo json_encode(['error' => 'Phone parameter is required']);
    exit;
}

// Load APIs
$apis = json_decode(file_get_contents(__DIR__ . '/apis.json'), true);
if (!$apis) {
    echo json_encode(['error' => 'Could not load APIs']);
    exit;
}

include_once __DIR__ . '/../includes/functions.php';

$results = [];
$successCount = 0;
$failCount = 0;

foreach ($apis as $api) {
    $url = str_replace('{{phone}}', urlencode($phone), $api['url']);
    $response = curl_get($url);

    $success = ($response !== false);

    if ($success) $successCount++;
    else $failCount++;

    $results[] = [
        'name' => $api['name'],
        'url' => $url,
        'success' => $success,
        'response' => $response,
    ];

    log_api_call($api['name'], $url, $response, $success);
}

echo json_encode([
    'phone' => $phone,
    'total' => count($apis),
    'success' => $successCount,
    'fail' => $failCount,
    'results' => $results,
]);