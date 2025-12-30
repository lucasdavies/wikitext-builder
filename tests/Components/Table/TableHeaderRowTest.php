<?php

namespace LucasDavies\WikitextBuilder\Tests\Components\Table;

use LucasDavies\WikitextBuilder\Components\Table\TableCell;
use LucasDavies\WikitextBuilder\Components\Table\TableHeaderRow;
use PHPUnit\Framework\TestCase;

class TableHeaderRowTest extends TestCase
{
    public function test_basic_table_header_row(): void
    {
        $expected = "|-\n!value 1!!value 2!!value 3";

        $actual = new TableHeaderRow(['value 1', 'value 2', 'value 3']);

        $this->assertEquals($expected, (string) $actual);
    }

    public function test_basic_table_header_row_with_cell_instances(): void
    {
        $expected = "|-\n!value 1!!value 2!!value 3";

        $actual = new TableHeaderRow([
            'value 1',
            new TableCell('value 2'),
            'value 3'
        ]);

        $this->assertEquals($expected, (string) $actual);
    }

    public function test_table_header_row_with_styles_applies_styles_to_each_cell(): void
    {
        $expected = "|-\n!style=\"background:#000;color:white\"|value 1!!style=\"background:#000;color:white\"|value 2!!style=\"background:#000;color:white\"|value 3";

        $actual = new TableHeaderRow(['value 1', 'value 2', 'value 3'])
            ->styles(['background' => '#000', 'color' => 'white']);

        $this->assertEquals($expected, (string) $actual);
    }
}
