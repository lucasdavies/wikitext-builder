<?php

namespace LucasDavies\WikitextBuilder\Tests\Components\List;

use LucasDavies\WikitextBuilder\Components\List\UnorderedList;
use PHPUnit\Framework\TestCase;

class UnorderedListTest extends TestCase
{
    public function test_unordered_list(): void
    {
        $expected = [
            '*Item1',
            '*Item2',
            '*Item3',
            '*Item4',
            '**Sub-item 4 a)',
            '***Sub-item 4 a) 1.',
            '****Sub-item 4 a) 1. i)',
            '****Sub-item 4 a) 1. ii)',
            '**Sub-item 4 b)',
            '*Item5',
        ];

        $actual = new UnorderedList([
            'Item1',
            'Item2',
            'Item3',
            'Item4' => [
                'Sub-item 4 a)' => [
                    'Sub-item 4 a) 1.' => [
                        'Sub-item 4 a) 1. i)',
                        'Sub-item 4 a) 1. ii)',
                    ],
                ],
                'Sub-item 4 b)',
            ],
            'Item5',
        ]);

        $this->assertEquals(implode("\n", $expected), (string) $actual);
    }
    public function test_spaced_unordered_list(): void
    {
        $expected = [
            '* Item1',
            '* Item2',
            '* Item3',
            '* Item4',
            '** Sub-item 4 a)',
            '*** Sub-item 4 a) 1.',
            '**** Sub-item 4 a) 1. i)',
            '**** Sub-item 4 a) 1. ii)',
            '** Sub-item 4 b)',
            '* Item5',
        ];

        $actual = new UnorderedList([
            'Item1',
            'Item2',
            'Item3',
            'Item4' => [
                'Sub-item 4 a)' => [
                    'Sub-item 4 a) 1.' => [
                        'Sub-item 4 a) 1. i)',
                        'Sub-item 4 a) 1. ii)',
                    ],
                ],
                'Sub-item 4 b)',
            ],
            'Item5',
        ])->spaced();

        $this->assertEquals(implode("\n", $expected), (string) $actual);
    }
}
