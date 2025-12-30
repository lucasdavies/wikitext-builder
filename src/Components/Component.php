<?php

namespace LucasDavies\WikitextBuilder\Components;

abstract class Component
{
    /**
     * How to render the wikitext component in string format.
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
