<?php

namespace LucasDavies\WikitextBuilder\Tests;

use LucasDavies\WikitextBuilder\Builder;
use LucasDavies\WikitextBuilder\Components\Table\Table;
use LucasDavies\WikitextBuilder\Components\Table\TableCell;
use PHPUnit\Framework\TestCase;

class BuilderTest extends TestCase
{
    private Builder $builder;

    protected function setUp(): void
    {
        parent::setUp();

        $this->builder = new Builder();
    }

    public function test_build_headings(): void
    {
        $this->assertEquals('==Heading 2==', $this->builder->heading('Heading 2', 2));
        $this->assertEquals('===Heading 3===', $this->builder->heading('Heading 3', 3));
        $this->assertEquals('====Heading 4====', $this->builder->heading('Heading 4', 4));
        $this->assertEquals('=====Heading 5=====', $this->builder->heading('Heading 5', 5));
        $this->assertEquals('======Heading 6======', $this->builder->heading('Heading 6', 6));
    }

    public function test_build_template(): void
    {
        $expected = '{{my template}}';

        $actual = $this->builder->template('my template');

        $this->assertEquals($expected, $actual);
    }

    public function test_build_template_with_params(): void
    {
        $expected = '{{my template|param1|param2}}';

        $actual = $this->builder
            ->template('my template')
            ->params(['param1', 'param2']);

        $this->assertEquals($expected, $actual);
    }

    public function test_build_template_with_params_as_second_arg(): void
    {
        $expected = '{{my template|param1|param2}}';

        $actual = $this->builder
            ->template('my template', ['param1', 'param2']);

        $this->assertEquals($expected, $actual);
    }

    public function test_build_template_with_spaced_and_aligned_params(): void
    {
        $expected = [
            '{{my template',
            '|param1 = value1',
            '|param2 = value2',
            '}}',
        ];

        $actual = $this->builder
            ->template('my template')
            ->multiline()
            ->aligned()
            ->params(['param1' => 'value1', 'param2' => 'value2']);

        $this->assertEquals(implode("\n", $expected), $actual);
    }

    public function test_build_table(): void
    {
        $expected = [
            '{| class="wikitable"',
            '|-',
            '!Header 1!!Header 2!!Header 3',
            '|-',
            '|Value 1||Value 2||Value 3',
            '|}'
        ];

        $actual = $this->builder->table(function (Table $table) {
            return $table
                ->headerRow(['Header 1', 'Header 2', 'Header 3'])
                ->bodyRow(['Value 1', 'Value 2', 'Value 3']);
        });

        $this->assertEquals(implode("\n", $expected), $actual);
    }

    public function test_build_complex_table(): void
    {
        $expected = [
            '{| class="wikitable"',
            '|-',
            '!Header 1!!Header 2!!Header 3',
            '|-',
            '|Value 1||Value 2||Value 3',
            '|-',
            '|Value 4||colspan=2|Value 5',
            '|-',
            '|Value 6',
            '|Value 7||Value 8',
            '|-',
            '|rowspan=2|Value 9',
            '|Value 10||Value 11',
            '|-',
            '|Value 12||Value 13',
            '|}',
        ];

        $actual = $this->builder->table(function (Table $table) {
            return $table
                ->headerRow(['Header 1', 'Header 2', 'Header 3'])
                ->bodyRow(['Value 1', 'Value 2', 'Value 3'])
                ->bodyRow(['Value 4', new TableCell('Value 5')->colspan(2)])
                ->bodyRow([['Value 6'], ['Value 7', 'Value 8']])
                ->bodyRow([[new TableCell('Value 9')->rowspan(2)], ['Value 10', 'Value 11']])
                ->bodyRow(['Value 12', 'Value 13']);
        });

        $this->assertEquals(implode("\n", $expected), $actual);
    }
}
