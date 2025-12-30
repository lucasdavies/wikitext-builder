<?php

namespace LucasDavies\WikitextBuilder\Traits;

trait HasAttributes
{
    protected function renderAttribute(string $attribute, array $values = []): string
    {
        return ! empty($values) ? $attribute . '="' . implode(' ', $values) . '"' : '';
    }
}
