<?php

namespace App\Logging;

use Monolog\Logger;

class MaximLogger
{
    public function __invoke(array $config): Logger
    {
        return new Logger(
            config('app.name'),
            [new MaximLoggerHandler(
                $config['host'],
                $config['port'],
            )]
        );
    }
}
