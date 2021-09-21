<?php

declare(strict_types = 1);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

require_once realpath('../../../vendor/autoload.php');

use MyApp\Models\PDODatabase;
use MyApp\Models\Todo;

$database = new PDODatabase();

$todo = new Todo($database);

$data = json_decode(file_get_contents("php://input"));

$todo->id = $data->id;

$todo->user_id = $data->user_id;
$todo->name = $data->name;

// TODO: check if authenticated
// TODO: check if authorized

if (! $todo->update()) {
    echo json_encode(
        array('message' => 'Todo not updated')
    );
    return;
}

echo json_encode(
    array('message' => 'Todo Updated')
);
