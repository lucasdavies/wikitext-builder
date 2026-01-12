<?php

namespace LucasDavies\WikitextBuilder\Tests\Components\List;

use LucasDavies\WikitextBuilder\Components\List\OrderedList;
use PHPUnit\Framework\TestCase;

class OrderedListTest extends TestCase
{
    public function test_ordered_list(): void
    {
        $expected = [
            '#Item1',
            '#Item2',
            '#Item3',
            '#Item4',
            '##Sub-item 1',
            '###Sub-sub-item',
            '####Sub-sub-sub-item',
            '##Sub-item 2',
            '#Item5',
        ];

        $actual = new OrderedList([
            'Item1',
            'Item2',
            'Item3',
            'Item4' => [
                'Sub-item 1' => [
                    'Sub-sub-item' => [
                        'Sub-sub-sub-item',
                    ],
                ],
                'Sub-item 2',
            ],
            'Item5',
        ]);

        $this->assertEquals(implode("\n", $expected), $actual);
    }
    public function test_spaced_ordered_list(): void
    {
        $expected = [
            '# Item1',
            '# Item2',
            '# Item3',
            '# Item4',
            '## Sub-item 1',
            '### Sub-sub-item',
            '#### Sub-sub-sub-item',
            '## Sub-item 2',
            '# Item5',
        ];

        $actual = new OrderedList([
            'Item1',
            'Item2',
            'Item3',
            'Item4' => [
                'Sub-item 1' => [
                    'Sub-sub-item' => [
                        'Sub-sub-sub-item',
                    ],
                ],
                'Sub-item 2',
            ],
            'Item5',
        ])->spaced();

        $this->assertEquals(implode("\n", $expected), $actual);
    }
}
