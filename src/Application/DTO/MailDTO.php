<?php

declare(strict_types=1);

namespace Application\DTO;

class MailDTO
{
    public string $sender;
    public string $recipient;
    public string $title;
    public string $message;

    public function __construct(array $data)
    {
        $this->sender = $data['sender'];
        $this->recipient = $data['recipient'];
        $this->title = $data['title'];
        $this->message = $data['message'];
    }
}
