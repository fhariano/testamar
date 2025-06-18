<?php

namespace App\Logging;

use Illuminate\Http\Request;
use Illuminate\Log\Logger;

class CustomizeFormatter
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function __invoke(Logger $logger)
    {
        if ($this->request) {
            foreach ($logger->getHandlers() as $handler) {
                $handler->pushProcessor([$this, 'processLogRecord']);
            }
        }
    }

    public function processLogRecord(array $record): array
    {
        $record['extra'] += [
            // 'user' => $this->request->user()->username ?? 'guest',
            'ip' => $this->request->ip(),
        ];

        return $record;
    }

}
