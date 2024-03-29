<?php declare(strict_types=1);

namespace System\Database;

use PDO;
use PDOException;
use System\Database\DTO\ConnectionDTO;

final class Connection
{
    private PDO $connect;

    private array $options = [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

    public function __construct(ConnectionDTO $options)
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

    public function getConnection(): PDO
    {
        return $this->connect;
    }
}