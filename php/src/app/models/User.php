<?php

namespace MyApp\Models;

use MyApp\Models\Model;
use \PDO;

class User extends Model
{
    private $table = 'users';

    private $connection;
    public $id;
    public $email;

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
          email
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
                email = :email';

        $stmt = $this->connection->prepare($query);

        $this->email = htmlspecialchars(strip_tags($this->email));

        $stmt->bindParam(':email', $this->email);

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
                email = :email
            WHERE
                id = :id';

        $stmt = $this->connection->prepare($query);

        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':id', $this->id);

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
