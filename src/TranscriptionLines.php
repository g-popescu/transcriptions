<?php

namespace Laracasts\Transcriptions;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use JsonSerializable;
use Traversable;

class TranscriptionLines implements Countable, IteratorAggregate, ArrayAccess, JsonSerializable
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

    public function offsetExists(mixed $key): bool
    {
        return isset($this->lines[$key]);
    }

    public function offsetGet(mixed $key): mixed
    {
        return $this->lines[$key] ?? null;
    }

    public function offsetSet(mixed $key, mixed $value): void
    {
        if ($key === NULL) {
            $this->lines[] = $value;
        } else if (!$this->offsetExists($key)) {
            $this->lines[$key] = $value;
        }
    }

    public function offsetUnset(mixed $key): void
    {
        if ($this->offsetExists($key)) {
            unset($this->lines[$key]);
        }
    }

    public function jsonSerialize(): mixed
    {
        return json_encode($this->lines);
    }
}
