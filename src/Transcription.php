<?php

namespace Laracasts\Transcriptions;

class Transcription
{
    public function __construct(
        protected array $lines
    ) {
        $this->lines = $this->discardInvalidLines($lines);
    }

    public static function load($transcriptFilePath): self
    {
        return new static(file($transcriptFilePath));
    }

    public function lines(): TranscriptionLines
    {
        return new TranscriptionLines(
            array_map(
                fn ($line) => new TranscriptionLine(...$line),
                array_chunk($this->lines, 3)
            )
        );
    }

    public function discardInvalidLines(array $lines): array
    {
        return array_slice(
            array_filter(
                array_map(
                    'trim',
                    $lines
                )
            ),
            1
        );
    }
}
