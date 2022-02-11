<?php

namespace Laracasts\Transcriptions;

class TranscriptionLine
{
    public function __construct(
        protected string $orderNo,
        protected string $timestamp,
        protected string $text,
    ) {
    }

    public function getStartTimestamp()
    {
        if (preg_match('/^\d{2}:(\d{2}:\d{2}\.\d{3}) /', $this->timestamp, $matches)) {
            return $matches[1];
        }
    }

    public function html(): string
    {
        return <<<EOT
            <a href="?time={$this->getStartTimestamp()}">{$this->text}</a>
            EOT;
    }

    public function __toString()
    {
        return "{$this->orderNo} - {$this->timestamp}: {$this->text}";
    }
}
