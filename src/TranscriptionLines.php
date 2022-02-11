<?php

namespace Laracasts\Transcriptions;

class TranscriptionLines extends Collection
{
    public function ashtml(): string
    {
        return (string) $this->map(fn (TranscriptionLine $line) => $line->html());
    }

    public function __toString(): string
    {
        return implode("\n", $this->items);
    }
}
