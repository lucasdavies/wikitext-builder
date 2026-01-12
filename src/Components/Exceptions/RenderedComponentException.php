<?php

namespace LucasDavies\WikitextBuilder\Components\Exceptions;

use LucasDavies\WikitextBuilder\Exceptions\WikitextBuilderException;

class RenderedComponentException extends WikitextBuilderException
{
    public static function spacedParamsMustBeMultiline(): static
    {
        return new static('Templates with spaced parameters must be multiline');
    }

    public static function invalidComponentArgument(string $message): static
    {
        return new static($message);
    }
}
