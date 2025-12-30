<?php

namespace LucasDavies\WikitextBuilder\Components\Table;

use LucasDavies\WikitextBuilder\Components\Component;
use LucasDavies\WikitextBuilder\Traits\HasClasses;
use LucasDavies\WikitextBuilder\Traits\HasStyles;

class Table extends Component
{
    use HasStyles;
    use HasClasses;

    /** @var TableRow[] */
    private array $rows = [];

    private string $caption = '';

    public function caption(string $caption): static
    {
        $this->caption = $caption;

        return $this;
    }

    public function headerRow(array|TableHeaderRow $values): static
    {
        $this->rows[] = $values instanceof TableHeaderRow ? $values : new TableHeaderRow($values);

        return $this;
    }

    public function bodyRow(array|TableBodyRow $values): static
    {
        $this->rows[] = $values instanceof TableBodyRow ? $values : new TableBodyRow($values);

        return $this;
    }

    public function render(): string
    {
        $string = '{|';

        // Begin with wikitable class
        array_unshift($this->classes, 'wikitable');

        $attributes = [];

        if (!empty($this->classes)) {
            $attributes[] = $this->renderClasses();
        }

        if (!empty($this->styles)) {
            $attributes[] = $this->renderStyles();
        }

        if (!empty($attributes)) {
            $string .= ' ' . implode(' ', $attributes);
        }

        $string .= "\n"
            . ($this->caption ? sprintf("|+ %s\n", $this->caption) : '')
            . implode("\n", array_map(static fn(TableRow $row): string => $row->render(), $this->rows));

        $string .= "\n|}";

        return $string;
    }
}
