<?php

namespace App\Microservices;

use Arr;
use Http;
use Illuminate\Http\Client\ConnectionException;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\MessageConverter;

class EmailTransport extends AbstractTransport
{
    public function __construct(
        protected string $host,
        protected int $port
    ) {
        parent::__construct();
    }

    /**
     * @throws ConnectionException
     */
    protected function doSend(SentMessage $message): void
    {
        $email = MessageConverter::toEmail($message->getOriginalMessage());
        $recipients = $email->getTo();
        $from = Arr::first($email->getFrom());

        foreach ($recipients as $recipient) {
            $data = [
                'to' => $recipient->getAddress(),
                'from' => $from->getAddress(),
                'subject' => $email->getSubject(),
                'html' => $email->getHtmlBody(),
            ];

            dump($data);

            Http::withBody(json_encode($data))
                ->post("http://$this->host:$this->port/send-email");
        }
    }

    public function __toString(): string
    {
        return 'maxim';
    }
}
