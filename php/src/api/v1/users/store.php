<?php

declare(strict_types = 1);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

require_once realpath('../../../vendor/autoload.php');

use MyApp\Models\User;
use MyApp\Models\PDODatabase;

$database = new PDODatabase;

$user = new User($database);

$data = json_decode(file_get_contents("php://input"));

$user->email = $data->email;

if (! $user->store()) {
    echo json_encode(
        array('message' => 'User Not Created')
    );

    return;
}

echo json_encode(
    array('message' => 'User Created')
);
