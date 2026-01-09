<?php

namespace LucasDavies\WikitextBuilder\Traits;

trait HasStyles
{
    use HasAttributes;

    protected array $styles = [];

    public function styles(array $styles): static
    {
        if (empty($styles)) {
            return $this;
        }

        // Remove any properties that are potentially being overwritten
        $this->styles = array_diff_key($this->styles, $styles);

        $this->styles = array_merge($this->styles, $styles);

        return $this;
    }

    public function textLeft(): static
    {
        $property = 'text-align';

        $this->clearPredefinedStyles($property);

        $this->styles[$property] = 'left';

        return $this;
    }

    public function textRight(): static
    {
        $property = 'text-align';

        $this->clearPredefinedStyles($property);

        $this->styles[$property] = 'right';

        return $this;
    }

    public function textCenter(): static
    {
        $property = 'text-align';

        $this->clearPredefinedStyles($property);

        $this->styles[$property] = 'center';

        return $this;
    }

    protected function renderStyles(string $prefix = ''): string
    {
        if (empty($this->styles)) {
            return '';
        }

        $glued = array_map(static fn($key, $value): string => sprintf('%s:%s', $key, $value), array_keys($this->styles), $this->styles);

        return $prefix . 'style="' . implode(';', $glued) . '"';
    }

    protected function clearPredefinedStyles(string $property): void
    {
        if (isset($this->styles[$property])) {
            unset($this->styles[$property]);
        }
    }
}
