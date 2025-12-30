<?php

namespace LucasDavies\WikitextBuilder\Components\List;

use LucasDavies\WikitextBuilder\Components\Component;

abstract class AbstractList extends Component
{
    protected string $marker;

    protected array $items = [];

    protected int $level;

    protected bool $spaced = false;

    public function __construct(array $items, int $level = 1)
    {
        $this->items = $items;
        $this->level = $level;
    }

    public function spaced(): static
    {
        $this->spaced = true;

        return $this;
    }

    public function render(): string
    {
        $marker = str_repeat($this->marker, $this->level);
        $spacer = $this->spaced ? ' ' : '';
        $lines = [];

        foreach ($this->items as $key => $item) {
            if (is_array($item)) {
                $lines[] = sprintf('%s%s%s', $marker, $spacer, $key);

                $nestedList = new static($item, $this->level + 1);

                if ($this->spaced) {
                    $nestedList->spaced();
                }

                foreach (explode("\n", $nestedList->render()) as $line) {
                    $lines[] = $line;
                }
            } else {
                $lines[] = sprintf('%s%s%s', $marker, $spacer, $item);
            }
        }

        return implode("\n", $lines);
    }
}
