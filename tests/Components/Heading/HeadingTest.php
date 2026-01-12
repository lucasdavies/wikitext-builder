<?php

namespace Components\Heading;

use LucasDavies\WikitextBuilder\Components\Exceptions\RenderedComponentException;
use LucasDavies\WikitextBuilder\Components\Heading\Heading;
use PHPUnit\Framework\TestCase;

class HeadingTest extends TestCase
{
    public function test_heading_all_levels(): void
    {
        $this->assertEquals('=Heading 1=', new Heading('Heading 1', 1));
        $this->assertEquals('==Heading 2==', new Heading('Heading 2', 2));
        $this->assertEquals('===Heading 3===', new Heading('Heading 3', 3));
        $this->assertEquals('====Heading 4====', new Heading('Heading 4', 4));
        $this->assertEquals('=====Heading 5=====', new Heading('Heading 5', 5));
        $this->assertEquals('======Heading 6======', new Heading('Heading 6', 6));
    }

    public function test_heading_all_levels_spaced(): void
    {
        $this->assertEquals('= Heading 1 =', new Heading('Heading 1', 1)->spaced());
        $this->assertEquals('== Heading 2 ==', new Heading('Heading 2', 2)->spaced());
        $this->assertEquals('=== Heading 3 ===', new Heading('Heading 3', 3)->spaced());
        $this->assertEquals('==== Heading 4 ====', new Heading('Heading 4', 4)->spaced());
        $this->assertEquals('===== Heading 5 =====', new Heading('Heading 5', 5)->spaced());
        $this->assertEquals('====== Heading 6 ======', new Heading('Heading 6', 6)->spaced());
    }

    public function test_heading_level_invalid(): void
    {
        $this->expectException(RenderedComponentException::class);
        $this->expectExceptionMessage('Invalid heading level "7". Level must be between 1 and 6.');

        new Heading('Heading 7', 7)->render();

        $this->expectException(RenderedComponentException::class);
        $this->expectExceptionMessage('Invalid heading level "0". Level must be between 1 and 6.');

        new Heading('Heading 0', 0)->render();
    }
}
