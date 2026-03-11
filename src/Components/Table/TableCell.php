<?php

namespace LucasDavies\WikitextBuilder\Components\Table;

use LucasDavies\WikitextBuilder\Components\Component;
use LucasDavies\WikitextBuilder\Traits\HasClasses;
use LucasDavies\WikitextBuilder\Traits\HasStyles;

class TableCell extends Component
{
    use HasStyles;
    use HasClasses;

    private(set) string $separator = '|';

    private(set) bool $hasExplicitSeparator = false;

    private string $value;

    private ?int $colspan = null;
    private ?int $rowspan = null;

    public function __construct(string $value, ?string $separator = null)
    {
        $this->value = $value;

        if ($separator !== null) {
            $this->separator = $separator;
            $this->hasExplicitSeparator = true;
        }
    }

    public function withSeparator(string $separator): static
    {
        $clone = clone $this;
        $clone->separator = $separator;

        return $clone;
    }

    public function colspan(int $value): static
    {
        $this->colspan = $value;

        return $this;
    }

    public function rowspan(int $value): static
    {
        $this->rowspan = $value;

        return $this;
    }

    public function render(): string
    {
        $string = $this->separator;

        $attributes = [];

        if (!empty($this->classes)) {
            $attributes[] = $this->renderClasses();
        }

        if (! empty($this->styles)) {
            $attributes[] = $this->renderStyles();
        }

        if ($this->colspan !== null) {
            $attributes[] = sprintf('colspan=%d', $this->colspan);
        }

        if ($this->rowspan !== null) {
            $attributes[] = sprintf('rowspan=%d', $this->rowspan);
        }

        if (! empty($attributes)) {
            $string .= implode(' ', $attributes) . '|';
        }

        return $string . $this->value;
    }
}
