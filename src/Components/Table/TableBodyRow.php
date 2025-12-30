<?php

namespace LucasDavies\WikitextBuilder\Components\Table;

use LucasDavies\WikitextBuilder\Traits\HasClasses;

class TableBodyRow extends TableRow
{
    use HasClasses;

    public function __construct(array $values, string $separator = '|')
    {
        parent::__construct($values, $separator);
    }

    public function render(): string
    {
        $string = '|-';

        // Apply the styles to the row

        $attributes = [];

        if (!empty($this->classes)) {
            $attributes[] = $this->renderClasses();
        }

        if (! empty($this->styles)) {
            $attributes[] = $this->renderStyles();
        }

        if (! empty($attributes)) {
            $string .= ' ' . implode(' ', $attributes);
        }

        return $string
            . "\n"
            . implode($this->separator, array_map(static fn(TableCell $value): string => $value->render(), $this->values));
    }
}
