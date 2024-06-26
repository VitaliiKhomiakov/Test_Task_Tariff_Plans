<?php declare(strict_types=1);

namespace Service;

use Service\DTO\MailDTO;

class MailService
{
    public function send(MailDTO $mailDTO)
    {
        /*
         * ...
         * implementation of sending mail messages
         */
    }

    public function tariffNotification(): void
    {
        $this->send(new MailDTO([
            'sender' => 'sender@sender.com',
            'recipient' => 'recipient@recipient.com',
            'title' => 'New tariff has been created',
            'message' => 'New tariff has been created .....',
        ]));
    }
}