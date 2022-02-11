<?php

namespace Laracasts\Transcriptions;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use JsonSerializable;
use Traversable;

class Collection implements Countable, IteratorAggregate, ArrayAccess, JsonSerializable
{
    public function __construct(protected array $items)
    {
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }

    public function offsetExists(mixed $key): bool
    {
        return isset($this->items[$key]);
    }

    public function offsetGet(mixed $key): mixed
    {
        return $this->items[$key] ?? null;
    }

    public function offsetSet(mixed $key, mixed $value): void
    {
        if ($key === NULL) {
            $this->items[] = $value;
        } else if (!$this->offsetExists($key)) {
            $this->items[$key] = $value;
        }
    }

    public function offsetUnset(mixed $key): void
    {
        if ($this->offsetExists($key)) {
            unset($this->items[$key]);
        }
    }

    public function jsonSerialize(): mixed
    {
        return json_encode($this->items);
    }

    public function map(mixed $fn): self
    {
        return new static(array_map($fn, $this->items));
    }
}
