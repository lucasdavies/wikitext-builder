<?php

namespace LucasDavies\WikitextBuilder\Components\Table;

use LucasDavies\WikitextBuilder\Components\Component;
use LucasDavies\WikitextBuilder\Traits\HasClasses;
use LucasDavies\WikitextBuilder\Traits\HasStyles;

class TableCell extends Component
{
    use HasStyles;
    use HasClasses;

    private string $separator;

    private string $value;

    private ?int $colspan = null;
    private ?int $rowspan = null;

    public function __construct(string $value, string $separator = '|')
    {
        $this->value = $value;
        $this->separator = $separator;
    }

    public function setSeparator(string $separator): static
    {
        $this->separator = $separator;

        return $this;
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
