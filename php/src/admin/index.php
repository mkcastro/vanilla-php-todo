<?php

declare(strict_types = 1);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

require_once realpath('../vendor/autoload.php');

use MyApp\Models\User;
use MyApp\Models\PDODatabase;

$database = new PDODatabase;

$user = new User($database);

$result = $user->index();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div>
    <h1 class="text-5xl text-center font-semibold">Users</h1>
    <div class="flex flex-col">
        <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>
            <div class="flex">
                <span class="border-2 border-grey">&#8226; <?php echo $row['email'] ?></span>
                <form action="/api/v1/users/index.php" method="post" class="flex">
                    <input type="hidden" name="method" value="patch">
                    <input type="hidden" name="id" value="<?php echo $user->id ?>">
                    <input type="text" name="email" class="border-2">
                    <input type="submit" value="Update" class="mr-2">
                </form>
                <form action="/api/v1/users/index.php" method="post" class="flex">
                    <input type="hidden" name="method" value="destroy">
                    <input type="hidden" name="id" value="<?php echo $user->id ?>">
                    <input type="submit" value="Destroy">
                </form>
            </div>
        <?php } ?>
        <div class="flex">
            <span>Create user: </span>
            <form action="/api/v1/users/index.php" method="post" class="flex">
                <input type="text" name="email" class="border-2">
                <input type="submit" value="Submit">
            </form>
        </div>

        <a href="/api/v1/users/index.php">View All</a>
    </div>
    </div>
    <div>
        <h1 class="text-5xl text-center font-semibold">Todos</h1>
    </div>

</body>
</html>
