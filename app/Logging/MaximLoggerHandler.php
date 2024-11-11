<?php

namespace App\Logging;

use Http;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\LogRecord;

class MaximLoggerHandler extends AbstractProcessingHandler
{
    public function __construct(
        protected string $host,
        protected int $port,
    ) {
        parent::__construct();
    }

    protected function write(LogRecord $record): void
    {
        $message = '['.now()->toDateTimeLocalString().'] '.
            $record->level->name.': '.
            $record->message.' '.
            json_encode(array_merge(
                $record->extra,
                $record->context
            ))."\n";

        Http::withBody(json_encode(compact('message')))
            ->post("http://$this->host:$this->port/log");
    }
}
