<?php

namespace LucasDavies\WikitextBuilder\Components\Table;

class TableHeaderRow extends TableRow
{
    public function __construct(array $values, string $separator = '!')
    {
        parent::__construct($values, $separator);
    }

    public function render(): string
    {
        $string = '|-';

        return $string
            . "\n"
            . implode($this->separator, array_map(function (TableCell $value): string {
                // Propagate the styles to the cell when in the header row context
                return $value->styles($this->styles)->render();
            }, $this->values));
    }
}
