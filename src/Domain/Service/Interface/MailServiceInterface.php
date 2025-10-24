<?php

declare(strict_types=1);

namespace Domain\Service\Interface;

use Application\DTO\MailDTO;

interface MailServiceInterface
{
    public function send(MailDTO $mailDTO): void;
}
