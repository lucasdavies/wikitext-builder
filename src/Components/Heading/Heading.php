<?php

namespace LucasDavies\WikitextBuilder\Components\Heading;

use LucasDavies\WikitextBuilder\Components\Component;
use LucasDavies\WikitextBuilder\Components\Exceptions\RenderedComponentException;

class Heading extends Component
{
    private bool $spaced = false;

    public function __construct(
        private readonly string $text,
        private readonly int    $level
    )
    {
        //
    }

    public function spaced(): static
    {
        $this->spaced = true;

        return $this;
    }

    public function render(): string
    {
        if ($this->level < 1 || $this->level > 6) {
            throw RenderedComponentException::invalidComponentArgument(sprintf('Invalid heading level "%d". Level must be between 1 and 6.', $this->level));
        }

        return sprintf('%2$s%3$s%1$s%3$s%2$s', $this->text, str_repeat('=', $this->level), $this->spaced ? ' ' : '');
    }
}
