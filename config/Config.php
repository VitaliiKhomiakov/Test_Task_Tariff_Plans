<?php

declare(strict_types=1);

final class Config
{
    public const bool DEBUG = true;

    private const string USER_DB = 'root';
    private const string PASS_DB = 'root_password';
    private const string DB_NAME = 'tariffs';
    private const string DB_HOST = 'database_tariffs';

    public static function DB(): array
    {
        return [
            'user' => self::USER_DB,
            'pass' => self::PASS_DB,
            'host' => self::DB_HOST,
            'databaseName' => self::DB_NAME,
        ];
    }

    private function __construct()
    {
    }
}
