<?php

function curl_get($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        curl_close($ch);
        return false;
    }
    curl_close($ch);
    return $response;
}

function log_api_call($api_name, $url, $response, $success) {
    $logDir = __DIR__ . '/../api/logs';
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
    $logFile = $logDir . '/' . date('Y-m-d') . '.log';
    $logEntry = "[" . date('Y-m-d H:i:s') . "] "
        . ($success ? "SUCCESS" : "FAIL") . " - $api_name - URL: $url - Response: " 
        . substr($response, 0, 200) . PHP_EOL;
    file_put_contents($logFile, $logEntry, FILE_APPEND);
}