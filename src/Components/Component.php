<?php

namespace LucasDavies\WikitextBuilder\Components;

use LucasDavies\WikitextBuilder\Components\Exceptions\RenderedComponentException;

abstract class Component
{
    /**
     * How to render the wikitext component in string format.
     *
     * @throws RenderedComponentException
     */
    abstract public function render(): string;

    /**
     * The string representation of the wikitext component.
     */
    public function __toString(): string
    {
        return $this->render();
    }
}
