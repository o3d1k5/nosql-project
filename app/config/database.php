<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use MongoDB\Client;

$uri = getenv('MONGO_URI')
    ?: 'mongodb://admin:admin123@mongodb:27017/?authSource=admin';

$dbName = getenv('MONGO_DB') ?: 'akademik';

try {
    $client = new Client($uri);

    $db = $client->selectDatabase($dbName);

} catch (Throwable $e) {

    http_response_code(500);
    die("Koneksi database gagal.");
}