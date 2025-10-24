<?php

declare(strict_types=1);

namespace Infrastructure\Notification;

class Message
{
    const string NOT_FOUND = 'Not Found';
    const string TARIFF_UPDATED = 'Tariff has been updated';
    const string TARIFF_DELETED = 'Tariff has been deleted';
    const string TARIFF_NOT_EXIST = 'Tariff type is not exist';

    public function createTariffMessage(string $name, int $id): string
    {
        return 'Tariff name ' . $name . ' with Id ' . $id . ' has been created';
    }

    public function updateTariffMessage(string $name, int $id): string
    {
        return 'Tariff name ' . $name . ' with Id ' . $id . ' has been updated';
    }
}