<?php

namespace LucasDavies\WikitextBuilder\Tests\Components\Table;

use LucasDavies\WikitextBuilder\Components\Table\TableCell;
use PHPUnit\Framework\TestCase;

class TableCellTest extends TestCase
{
    public function test_basic_table_cell(): void
    {
        $this->assertEquals(
            '|value',
            new TableCell('value')
        );
    }

    public function test_table_cell_with_styles(): void
    {
        $expected = '|style="text-align:left;color:green"|value';

        $actual = new TableCell('value')
            ->styles(['text-align' => 'left', 'color' => 'green']);

        $this->assertEquals($expected, $actual);
    }

    public function test_table_cell_with_classes(): void
    {
        $expected = '|class="class1 class2 class3"|value';

        $actual = new TableCell('value')
            ->classes(['class1', 'class2', 'class3']);

        $this->assertEquals($expected, $actual);
    }

    public function test_table_cell_with_both_styles_and_classes(): void
    {
        $expected = '|class="class1 class2 class3" style="text-align:left;color:green"|value';

        $actual = new TableCell('value')
            ->styles(['text-align' => 'left', 'color' => 'green'])
            ->classes(['class1', 'class2', 'class3']);

        $this->assertEquals($expected, $actual);
    }

    public function test_table_cell_with_rowspan(): void
    {
        $this->assertEquals(
            '|rowspan=2|value',
            new TableCell('value')->rowspan(2)
        );
    }

    public function test_table_cell_with_colspan(): void
    {
        $this->assertEquals(
            '|colspan=2|value',
            new TableCell('value')->colspan(2)
        );
    }

    public function test_table_cell_with_both_rowspan_and_colspan()
    {
        $actual = new TableCell('value')
            ->colspan(2)
            ->rowspan(3);

        $this->assertEquals('|colspan=2 rowspan=3|value', $actual);
    }

    public function test_table_cell_with_styles_classes_rowspan_and_colspan(): void
    {
        $expected = '|class="class1 class2 class3" style="text-align:left;color:green" colspan=3 rowspan=2|value';

        $actual = new TableCell('value')
            ->styles(['text-align' => 'left', 'color' => 'green'])
            ->classes(['class1', 'class2', 'class3'])
            ->colspan(3)
            ->rowspan(2);

        $this->assertEquals($expected, $actual);
    }

    public function test_table_cell_with_predefined_styles(): void
    {
        // Specifying predefined style first
        $this->assertEquals(
            '|style="text-align:center;color:green"|value',
            new TableCell('value')->textCenter()->styles(['color' => 'green'])
        );

        // Specifying predefined style last
        $this->assertEquals(
            '|style="color:green;text-align:center"|value',
            new TableCell('value')->styles(['color' => 'green'])->textCenter()
        );

        // Specifying predefined style first with same style in styles array
        $this->assertEquals(
            '|style="color:green;text-align:center"|value',
            new TableCell('value')->textCenter()->styles(['color' => 'green', 'text-align' => 'center'])
        );

        // Specifying predefined style last with same style in styles array last
        $this->assertEquals(
            '|style="color:green;text-align:center"|value',
            new TableCell('value')->styles(['color' => 'green', 'text-align' => 'center'])->textCenter()
        );

        // Specifying predefined style last with same style in styles array first
        $this->assertEquals(
            '|style="color:green;text-align:center"|value',
            new TableCell('value')->styles(['text-align' => 'center', 'color' => 'green'])->textCenter()
        );
    }

    public function test_table_cell_with_predefined_styles_are_overwritten(): void
    {
        $actual = new TableCell('value')
            ->textCenter() // Specify predefined style first
            ->styles(['color' => 'green', 'text-align' => 'left']); // Overwrite text-align style

        $this->assertEquals('|style="color:green;text-align:left"|value', $actual);
    }

    public function test_table_cell_with_multiple_predefined_styles_are_overwritten(): void
    {
        $actual = new TableCell('value')
            ->textCenter() // Specify predefined style first
            ->styles(['color' => 'green', 'text-align' => 'left']) // Overwrite text-align style
            ->textRight(); // Overwrite predefined style again with another predefined style

        $this->assertEquals('|style="color:green;text-align:right"|value', $actual);
    }
}
