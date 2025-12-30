<?php

namespace LucasDavies\WikitextBuilder\Traits;

trait HasClasses
{
    use HasAttributes;

    protected array $classes = [];

    public function classes(array $classes = []): static
    {
        $this->classes = $classes;

        return $this;
    }

    protected function renderClasses(): string
    {
        return $this->renderAttribute('class', $this->classes);
    }
}
