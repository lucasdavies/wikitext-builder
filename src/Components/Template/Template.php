<?php

namespace LucasDavies\WikitextBuilder\Components\Template;

use LucasDavies\WikitextBuilder\Components\Component;
use LucasDavies\WikitextBuilder\Components\Exceptions\RenderedComponentException;

class Template extends Component
{
    private string $name;

    private bool $multiline = false;
    private bool $spaced = false;
    private bool $aligned = false;

    private array $params = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function multiline(): static
    {
        $this->multiline = true;

        return $this;
    }

    public function spaced(): static
    {
        $this->spaced = true;

        return $this;
    }

    public function aligned(): static
    {
        $this->aligned = true;

        return $this;
    }

    public function params(array $params): static
    {
        $this->params = $params;

        return $this;
    }

    public function render(): string
    {
        if ($this->spaced && !$this->multiline) {
            throw RenderedComponentException::spacedParamsMustBeMultiline();
        }

        $string = sprintf('{{%s', $this->name);

        if (empty($this->params)) {
            return $string . '}}';
        }

        $isUnnamedArgs = array_is_list($this->params);
        $argSeparator = $this->multiline ? "\n|" : '|';
        $maxParamLength = $this->aligned && !$isUnnamedArgs ? max(array_map('strlen', array_keys($this->params))) : null;

        $formattedArgs = [];

        foreach ($this->params as $param => $value) {
            if (is_array($value)) {
                // Nested parameter group
                $formattedArgs[] = implode('|', array_map(function ($params, $values) {
                    return $this->formatSingleParameter($params, $values, false);
                }, array_keys($value), $value));
            } else {
                $formattedArgs[] = $this->formatSingleParameter($param, $value, $maxParamLength);
            }
        }

        $opening = sprintf('{{%s', $this->name);
        $closing = $this->multiline ? "\n}}" : '}}';
        $firstSeparator = $this->multiline ? "\n|" : '|';

        return $opening . $firstSeparator . implode($argSeparator, $formattedArgs) . $closing;

    }

    private function formatSingleParameter(int|string $param, $value, ?int $maxParamLength): string
    {
        if (is_int($param)) {
            // This is an unnamed parameter
            return $value;
        }

        $spacer = ($this->spaced || $this->aligned) ? ' ' : '';

        if ($maxParamLength !== null) {
            $param = str_pad($param, $maxParamLength);
        }

        return sprintf('%s%s=%s%s', $param, $spacer, $spacer, $value);
    }
}
