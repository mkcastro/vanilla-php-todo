<?php

declare(strict_types = 1);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Methods: GET');

require_once realpath('../../../vendor/autoload.php');

use MyApp\Models\User;
use MyApp\Models\PDODatabase;

$database = new PDODatabase;

$user = new User($database);

$result = $user->index();

$response = [
    'message' => '',
    'data' => [],
];

$count = $result->rowCount();

if (! $count) {
    $response['message'] = 'No Users Exist.';

    echo json_encode($response);
    return;
}

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $response['data'][] = [
        'id' => (int) $row['id'],
        'email' => $row['email'],
    ];
}

$response['message'] = "Found $count users.";
echo json_encode($response);
