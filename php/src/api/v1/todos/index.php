<?php

declare(strict_types = 1);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Methods: GET');

require_once realpath('../../../vendor/autoload.php');

use MyApp\Models\PDODatabase;
use MyApp\Models\Todo;

$database = new PDODatabase;

$todo = new Todo($database);

$result = $todo->index();

$response = [
    'message' => '',
    'data' => [],
];

$count = $result->rowCount();

if (! $count) {
    $response['message'] = 'No todos Exist.';

    echo json_encode($response);
    return;
}

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $response['data'][] = [
        'id' => (int) $row['id'],
        'user_id' => $row['user_id'],
        'name' => $row['name'],
    ];
}

$response['message'] = "Found $count todos.";
echo json_encode($response);
