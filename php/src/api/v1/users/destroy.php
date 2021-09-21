<?php

declare(strict_types = 1);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

require_once realpath('../../../vendor/autoload.php');

use MyApp\Models\PDODatabase;
use MyApp\Models\User;

$database = new PDODatabase();

$user = new User($database);

$data = json_decode(file_get_contents("php://input"));

$user->id = $data->id;

if (! $user->exists()) {
    echo json_encode(
        array('message' => 'User doesn\'t exist.')
    );

    return;
}

if (! $user->destroy()) {
    echo json_encode(
        array('message' => 'User not deleted')
    );

    return;
}

echo json_encode(
    array('message' => 'User deleted.')
);
