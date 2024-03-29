<?php declare(strict_types=1);

namespace System\Database;

use PDO;
use PDOException;

final class Connection
{
    private PDO $connect;
    private static Connection $db;

    private array $options = [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

    private function __construct(ConnectionDTO $options)
    {
        try {
            $this->connect = new PDO('mysql:host='. $options->host .';dbname='. $options->databaseName,
                $options->user,
                $options->pass,
                $this->options
            );
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
            exit();
        }
    }

    public static function connect(ConnectionDTO $options): self
    {
        if (!self::$db) {
            self::$db = new self($options);
        }

        return self::$db;
    }

    public function getConnection(): PDO
    {
        return $this->connect;
    }

    private function __clone() {}

    public function __wakeup()
    {
        throw new \Exception('Cannot unserialize a singleton.');
    }
}