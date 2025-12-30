<?php

namespace LucasDavies\WikitextBuilder\Components\Table;

use LucasDavies\WikitextBuilder\Components\Component;
use LucasDavies\WikitextBuilder\Traits\HasStyles;

abstract class TableRow extends Component
{
    use HasStyles;

    protected string $separator;

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
                if (!($value instanceof TableCell)) {
                    $this->values[] = new TableCell($value, $separator);
                } else {
                    // Update the cell separator depending on row context (body or header)
                    $this->values[] = $value->setSeparator($separator);
                }
            }
        }

        $this->separator = $separator;
    }
}
