<?php

namespace LucasDavies\WikitextBuilder\Tests\Components\Template;

use LucasDavies\WikitextBuilder\Components\Exceptions\RenderedComponentException;
use LucasDavies\WikitextBuilder\Components\Template\Template;
use PHPUnit\Framework\TestCase;

class TemplateTest extends TestCase
{
    public function test_basic_template(): void
    {
        $this->assertEquals('{{my template}}', new Template('my template'));
    }

    public function test_template_with_unnamed_parameters(): void
    {
        $actual = new Template('my template')
            ->params(['value1', 'value2']);

        $this->assertEquals('{{my template|value1|value2}}', $actual);
    }

    public function test_template_with_named_parameters(): void
    {
        $actual = new Template('my template')
            ->params([
                'arg1' => 'value1',
                'arg2' => 'value2',
            ]);

        $this->assertEquals('{{my template|arg1=value1|arg2=value2}}', $actual);
    }

    public function test_template_with_multiline_named_parameters(): void
    {
        $expected = [
            '{{my template',
            '|arg1=value1',
            '|arg2=value2',
            '|arg3=value3',
            '}}',
        ];

        $actual = new Template('my template')
            ->multiline()
            ->params([
                'arg1' => 'value1',
                'arg2' => 'value2',
                'arg3' => 'value3',
            ]);

        $this->assertEquals(implode("\n", $expected), $actual);
    }

    public function test_template_with_multiline_unnamed_parameters(): void
    {
        $expected = [
            '{{my template',
            '|arg1',
            '|arg2',
            '|arg3',
            '}}',
        ];

        $actual = new Template('my template')
            ->multiline()
            ->params(['arg1', 'arg2', 'arg3',]);

        $this->assertEquals(implode("\n", $expected), $actual);
    }

    public function test_template_with_spaced_multiline_named_parameters(): void
    {
        $expected = [
            '{{my template',
            '|arg1 = value1',
            '|arg2 = value2',
            '|arg3 = value3',
            '}}',
        ];

        $actual = new Template('my template')
            ->multiline()
            ->spaced()
            ->params([
                'arg1' => 'value1',
                'arg2' => 'value2',
                'arg3' => 'value3',
            ]);

        $this->assertEquals(implode("\n", $expected), $actual);
    }

    public function test_template_with_spaced_parameters_must_be_multiline(): void
    {
        $template = new Template('my template')
            ->spaced()
            ->params([
                'arg1' => 'value1',
                'arg2' => 'value2',
                'arg3' => 'value3',
            ]);

        $this->expectException(RenderedComponentException::class);
        $this->expectExceptionMessage('Templates with spaced parameters must be multiline');

        $template->render();
    }

    public function test_template_with_aligned_multiline_named_parameters(): void
    {
        $expected = [
            '{{my template',
            '|first arg             = value1',
            '|arg2                  = value2',
            '|this is the third arg = value3',
            '}}',
        ];

        $actual = new Template('my template')
            ->multiline()
            ->aligned()
            ->params([
                'first arg' => 'value1',
                'arg2' => 'value2',
                'this is the third arg' => 'value3',
            ]);

        $this->assertEquals(implode("\n", $expected), $actual);
    }

    public function test_template_with_aligned_multiline_unnamed_parameters(): void
    {
        $expected = [
            '{{my template',
            '|first arg',
            '|arg2',
            '|this is the third arg',
            '}}',
        ];

        $actual = new Template('my template')
            ->multiline()
            ->aligned()
            ->params([
                'first arg',
                'arg2',
                'this is the third arg',
            ]);

        $this->assertEquals(implode("\n", $expected), $actual);
    }

    // Template with aligned and spaced multiline parameters does nothing
    public function test_template_with_explicitly_spaced_and_aligned_multiline_named_parameters_makes_no_difference_to_formatting(): void
    {
        $expected = [
            '{{my template',
            '|first arg             = value1',
            '|arg2                  = value2',
            '|this is the third arg = value3',
            '}}',
        ];

        $actual = new Template('my template')
            ->multiline()
            ->spaced()
            ->aligned()
            ->params([
                'first arg' => 'value1',
                'arg2' => 'value2',
                'this is the third arg' => 'value3',
            ]);

        $this->assertEquals(implode("\n", $expected), $actual);
    }

    public function test_templates_with_multiline_named_parameters_can_have_named_parameters_on_one_line(): void
    {
        $expected = [
            '{{my template',
            '|arg1=value1',
            '|arg2=value2',
            '|arg3=value3|arg4=value4|arg5=value5',
            '|arg6=value6',
            '}}',
        ];

        $actual = new Template('my template')
            ->multiline()
            ->params([
                'arg1' => 'value1',
                'arg2' => 'value2',
                ['arg3' => 'value3', 'arg4' => 'value4', 'arg5' => 'value5'],
                'arg6' => 'value6',
            ]);

        $this->assertEquals(implode("\n", $expected), $actual);
    }

    public function test_templates_with_multiline_named_parameters_can_have_spaced_named_parameters_on_one_line(): void
    {
        $expected = [
            '{{my template',
            '|arg1 = value1',
            '|arg2 = value2',
            '|arg3 = value3|arg4 = value4|arg5 = value5',
            '|arg6 = value6',
            '}}',
        ];

        $actual = new Template('my template')
            ->multiline()
            ->spaced()
            ->params([
                'arg1' => 'value1',
                'arg2' => 'value2',
                ['arg3' => 'value3', 'arg4' => 'value4', 'arg5' => 'value5'],
                'arg6' => 'value6',
            ]);

        $this->assertEquals(implode("\n", $expected), $actual);
    }

    public function test_templates_with_multiline_unnamed_parameters_can_have_unnamed_parameters_on_one_line(): void
    {
        $expected = [
            '{{my template',
            '|arg1',
            '|arg2',
            '|arg3|arg4|arg5',
            '|arg6',
            '}}',
        ];

        $actual = new Template('my template')
            ->multiline()
            ->params([
                'arg1',
                'arg2',
                ['arg3', 'arg4', 'arg5'],
                'arg6',
            ]);

        $this->assertEquals(implode("\n", $expected), $actual);
    }
}
