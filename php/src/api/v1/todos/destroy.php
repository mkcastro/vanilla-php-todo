<?php

declare(strict_types = 1);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

require_once realpath('../../../vendor/autoload.php');

use MyApp\Models\PDODatabase;
use MyApp\Models\Todo;

$database = new PDODatabase();

$todo = new Todo($database);

$data = json_decode(file_get_contents("php://input"));

$todo->id = $data->id;

// TODO: check if authenticated
// TODO: check ownership

if (! $todo->exists()) {
    echo json_encode(
        array('message' => 'Todo doesn\'t exist.')
    );

    return;
}

if (! $todo->destroy()) {
    echo json_encode(
        array('message' => 'Todo not deleted')
    );

    return;
}

echo json_encode(
    array('message' => 'Todo deleted.')
);
