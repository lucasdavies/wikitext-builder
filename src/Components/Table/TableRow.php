<?php

namespace LucasDavies\WikitextBuilder\Components\Table;

use LucasDavies\WikitextBuilder\Components\Component;
use LucasDavies\WikitextBuilder\Traits\HasStyles;

abstract class TableRow extends Component
{
    use HasStyles;

    protected string $separator;

    /** @var array Lines of text that make up this row. */
    protected array $lines = [];

    /** @var TableCell[] */
    protected array $values = [];

    /**
     * @param array $values
     * @param string $separator
     */
    public function __construct(array $values, string $separator)
    {
        if (!empty($values)) {
            foreach ($values as $value) {
                if (is_array($value)) {
                    // This is a multi-line cell.
                    $this->lines[] = array_map(function ($value) use ($separator) {
                        return $this->handleCellValue($value, $separator);
                    }, $value);

                    continue;
                }

                $this->lines[0][] = $this->handleCellValue($value, $separator);
            }
        }

        $this->separator = $separator;
    }

    private function handleCellValue($value, $separator)
    {
        if ($value instanceof TableCell) {
            // Update the cell separator depending on row context (body or header)
            return $value->setSeparator($separator);
        }

        return new TableCell($value, $separator);
    }
}
