<?php

namespace MyApp\Models;

use MyApp\Models\Model;
use \PDO;

class Todo extends Model
{
    private $table = 'todos';

    private $connection;
    public $id;
    public $user_id;
    public $name;

    public function __construct(DatabaseInterface $database)
    {
        $this->connection = $database->connect();
    }

    public function index()
    {
        $query = 'SELECT * FROM ' . $this->table;

        $stmt = $this->connection->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function exists(): bool
    {
        $query = 'SELECT
          id,
          user_id
        FROM
          ' . $this->table . '
        WHERE id = ?
        LIMIT 0,1';

        $stmt = $this->connection->prepare($query);

        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        $result = $stmt;

        return !! $result->rowCount();
    }

    public function store(): bool
    {
        $query = 'INSERT INTO ' .
                $this->table . '
            SET
                user_id = :user_id
                name = :name';

        $stmt = $this->connection->prepare($query);

        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->name = htmlspecialchars(strip_tags($this->name));

        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':name', $this->name);

        if (! $stmt->execute()) {
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        return true;
    }

    public function update(): bool
    {
        $query = 'UPDATE ' .
            $this->table . '
            SET
                user_id = :user_id,
                name = :name
            WHERE
                id = :id';

        $stmt = $this->connection->prepare($query);

        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->name = htmlspecialchars(strip_tags($this->name));

        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':name', $this->name);

        if (! $stmt->execute()) {
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        return true;
    }

    public function destroy(): bool
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        $stmt = $this->connection->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id', $this->id);

        if (! $stmt->execute()) {
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        return true;
    }
}
