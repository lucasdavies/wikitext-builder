<?php

namespace LucasDavies\WikitextBuilder\Tests\Components\Table;

use LucasDavies\WikitextBuilder\Components\Table\TableBodyRow;
use LucasDavies\WikitextBuilder\Components\Table\TableCell;
use PHPUnit\Framework\TestCase;

class TableBodyRowTest extends TestCase
{
    public function test_basic_table_body_row(): void
    {
        $expected = "|-\n|value 1||value 2||value 3";

        $actual = new TableBodyRow(['value 1', 'value 2', 'value 3']);

        $this->assertEquals($expected, $actual);
    }

    public function test_basic_table_body_row_with_cell_instances(): void
    {
        $expected = "|-\n|value 1||value 2||value 3";

        $actual = new TableBodyRow([
            'value 1',
            new TableCell('value 2'),
            'value 3'
        ]);

        $this->assertEquals($expected, $actual);
    }

    public function test_table_body_row_with_styles(): void
    {
        $expected = "|- style=\"background:#000;color:white\"\n|value 1||value 2||value 3";

        $actual = new TableBodyRow(['value 1', 'value 2', 'value 3'])
            ->styles(['background' => '#000', 'color' => 'white']);

        $this->assertEquals($expected, $actual);
    }

    public function test_table_body_row_with_classes(): void
    {
        $expected = "|- style=\"background:#000;color:white\"\n|value 1||value 2||value 3";

        $actual = new TableBodyRow(['value 1', 'value 2', 'value 3'])
            ->styles(['background' => '#000', 'color' => 'white']);

        $this->assertEquals($expected, $actual);
    }

    public function test_table_body_row_with_both_styles_and_classes(): void
    {
        $expected = [
            '|- class="class1 class2 class3" style="background:#000;color:white"',
            '|value 1||value 2||value 3',
        ];

        $actual = new TableBodyRow(['value 1', 'value 2', 'value 3'])
            ->styles(['background' => '#000', 'color' => 'white'])
            ->classes(['class1', 'class2', 'class3']);

        $this->assertEquals(implode("\n", $expected), $actual);
    }

    public function test_table_body_row_split_across_multiple_lines(): void
    {
        $expected = [
            '|-',
            '|value 1||value 2||value 3',
            '|value 4||value 5'
        ];

        $actual = new TableBodyRow([
            ['value 1', 'value 2', 'value 3'],
            ['value 4', 'value 5'],
        ]);

        $this->assertEquals(implode("\n", $expected), $actual);
    }
}
