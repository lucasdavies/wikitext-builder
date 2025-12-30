<?php

namespace LucasDavies\WikitextBuilder\Traits;

trait HasStyles
{
    use HasAttributes;

    protected array $styles = [];

    public function styles(array $styles): static
    {
        $this->styles = $styles;

        return $this;
    }

    protected function renderStyles(string $prefix = ''): string
    {
        if (!empty($this->styles)) {
            return $prefix . 'style="' . implode(';', array_map(static function ($key, $value): string {
                    return sprintf('%s:%s', $key, $value);
                }, array_keys($this->styles), $this->styles)) . '"';
        }

        return '';
    }
}
