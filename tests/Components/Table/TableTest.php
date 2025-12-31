<?php

namespace LucasDavies\WikitextBuilder\Tests\Components\Table;

use LucasDavies\WikitextBuilder\Components\Table\Table;
use LucasDavies\WikitextBuilder\Components\Table\TableBodyRow;
use LucasDavies\WikitextBuilder\Components\Table\TableCell;
use LucasDavies\WikitextBuilder\Components\Table\TableHeaderRow;
use PHPUnit\Framework\TestCase;

class TableTest extends TestCase
{
    public function test_basic_table(): void
    {
        $expected = [
            '{| class="wikitable"',
            '|-',
            '!Header 1!!Header 2!!Header 3',
            '|-',
            '|Value 1||Value 2||Value 3',
            '|}'
        ];

        $actual = new Table()
            ->headerRow(['Header 1', 'Header 2', 'Header 3'])
            ->bodyRow(['Value 1', 'Value 2', 'Value 3']);

        $this->assertEquals(implode("\n", $expected), $actual);
    }

    public function test_basic_table_can_supply_own_row_and_cell_instances(): void
    {
        $expected = [
            '{| class="wikitable"',
            '|-',
            '!Header 1!!Header 2!!Header 3',
            '|-',
            '|Value 1||Value 2||Value 3',
            '|-',
            '|Value 4||Value 5||Value 6',
            '|}'
        ];

        $actual = new Table()
            ->headerRow(new TableHeaderRow(['Header 1', 'Header 2', 'Header 3']))
            ->bodyRow(['Value 1', 'Value 2', 'Value 3'])
            ->bodyRow(new TableBodyRow([
                'Value 4',
                new TableCell('Value 5'),
                'Value 6'
            ]));

        $this->assertEquals(implode("\n", $expected), $actual);
    }

    public function test_basic_table_with_styles(): void
    {
        $expected = [
            '{| class="wikitable" style="text-align:center;float:left"',
            '|-',
            '!Header 1!!Header 2!!Header 3',
            '|-',
            '|Value 1||Value 2||Value 3',
            '|}'
        ];

        $actual = new Table()
            ->styles(['text-align' => 'center', 'float' => 'left'])
            ->headerRow(['Header 1', 'Header 2', 'Header 3'])
            ->bodyRow(['Value 1', 'Value 2', 'Value 3']);

        $this->assertEquals(implode("\n", $expected), $actual);
    }

    public function test_basic_table_with_classes(): void
    {
        $expected = [
            '{| class="wikitable class1 class2"',
            '|-',
            '!Header 1!!Header 2!!Header 3',
            '|-',
            '|Value 1||Value 2||Value 3',
            '|}'
        ];

        $actual = new Table()
            ->classes(['class1', 'class2'])
            ->headerRow(['Header 1', 'Header 2', 'Header 3'])
            ->bodyRow(['Value 1', 'Value 2', 'Value 3']);

        $this->assertEquals(implode("\n", $expected), $actual);
    }

    public function test_basic_table_with_both_styles_and_classes(): void
    {
        $expected = [
            '{| class="wikitable class1 class2" style="text-align:center;float:left"',
            '|-',
            '!Header 1!!Header 2!!Header 3',
            '|-',
            '|Value 1||Value 2||Value 3',
            '|}'
        ];

        $actual = new Table()
            ->styles(['text-align' => 'center', 'float' => 'left'])
            ->classes(['class1', 'class2'])
            ->headerRow(['Header 1', 'Header 2', 'Header 3'])
            ->bodyRow(['Value 1', 'Value 2', 'Value 3']);

        $this->assertEquals(implode("\n", $expected), $actual);
    }

    public function test_basic_table_with_caption(): void
    {
        $expected = [
            '{| class="wikitable"',
            '|+ This is a caption',
            '|-',
            '!Header 1!!Header 2!!Header 3',
            '|-',
            '|Value 1||Value 2||Value 3',
            '|}'
        ];

        $actual = new Table()
            ->caption('This is a caption')
            ->headerRow(['Header 1', 'Header 2', 'Header 3'])
            ->bodyRow(['Value 1', 'Value 2', 'Value 3']);

        $this->assertEquals(implode("\n", $expected), $actual);
    }
}
