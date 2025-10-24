<?php declare(strict_types=1);

namespace Model;

final class Log
{
    private int $id;
    private array $data;
    private \DateTime $dateTime;

    public function __construct(array $data)
    {
        $this->id = (int)$data['id'];
        $this->data = $data['data'];
        $this->dateTime = $data['date'];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getDateTime(): \DateTime
    {
        return $this->dateTime;
    }
}
