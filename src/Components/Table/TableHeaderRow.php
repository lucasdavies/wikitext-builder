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
            . implode("\n", array_map(function (array $line): string {
                return implode($this->separator, array_map(function (TableCell $cell): string {
                    // Propagate the styles to the cell when in the header row context
                    return $cell->styles($this->styles)->render();
                }, $line));
            }, $this->lines));
    }
}
