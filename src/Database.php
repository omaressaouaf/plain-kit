<?php


declare(strict_types=1);

namespace Omaressaouaf\PlainKit;

use PDO;
use PDOException;
use PDOStatement;

class Database
{
    protected Response $response;

    protected PDO $connection;

    protected PDOStatement|bool $statement;

    protected string $queryString = "";

    protected array $params = [];

    public function __construct()
    {
        $this->response = App::resolve(Response::class);

        try {
            $config = require base_path("config/app.php");

            $dsn = "mysql:" . http_build_query($config['database']['connection'], '', ';');

            $this->connection = new PDO(
                $dsn,
                $config['database']['username'],
                $config['database']['password'],
                [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
            );
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();

            exit();
        }
    }

    public function query(string $query, array $params = []): self
    {
        $this->statement = $this->connection->prepare($query);

        $this->statement->execute($params);

        return $this;
    }

    public function get(): array
    {
        return $this->statement->fetchAll();
    }

    public function find(): mixed
    {
        return $this->statement->fetch();
    }

    public function findOrFail(): mixed
    {
        $result = $this->find();

        if (! $result) {
            $this->response->abort();
        }

        return $result;
    }
}
