<?php

namespace Laracasts\Transcriptions;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use PhpParser\Node\Expr\FuncCall;
use Traversable;

class TranscriptionLines implements Countable, IteratorAggregate
{
    public function __construct(protected array $lines)
    {
    }

    public function ashtml(): string
    {
        return implode(
            "\n",
            array_map(
                fn (TranscriptionLine $line) => $line->html(),
                $this->lines
            )
        );
    }

    public function __toString(): string
    {
        return implode("\n", $this->lines);
    }

    public function count(): int
    {
        return count($this->lines);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->lines);
    }
}
