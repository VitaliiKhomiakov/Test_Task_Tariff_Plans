<?php

final class Config
{
    const DEBUG = true;

    const USER_DB = 'root';
    const PASS_DB = 'root_password';
    const DB_NAME = 'tariffs';
    const DB_HOST = 'database_tariffs';

    static function DB(): array
    {
        return [
            'user' => self::USER_DB,
            'pass' => self::PASS_DB,
            'host' => self::DB_HOST,
            'databaseName' => self::DB_NAME,
        ];
    }

    private function __construct() {}
}