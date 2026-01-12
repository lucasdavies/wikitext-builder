<?php

namespace LucasDavies\WikitextBuilder;

use Closure;
use LucasDavies\WikitextBuilder\Components\Heading\Heading;
use LucasDavies\WikitextBuilder\Components\List\OrderedList;
use LucasDavies\WikitextBuilder\Components\List\UnorderedList;
use LucasDavies\WikitextBuilder\Components\Table\Table;
use LucasDavies\WikitextBuilder\Components\Template\Template;

class Builder
{
    public function __construct(
        private array $components = []
    )
    {
        //
    }

    public function __toString(): string
    {
        return $this->render();
    }

    public function render(): string
    {
        if (empty($this->components)) {
            return '';
        }

        return implode("\n", array_map(fn($component) => $component->render(), $this->components));
    }

    /**
     * Builds a Heading component.
     */
    public function heading(string $content, int $level): Heading
    {
        return $this->components[] = new Heading($content, $level);
    }

    /**
     * Builds a Template component.
     */
    public function template(string $name, array $params = []): Template
    {
        return $this->components[] = new Template($name)->params($params);
    }

    /**
     * Builds a Table component.
     */
    public function table(Closure $closure): Table
    {
        return $closure(new Table());
    }

    /**
     * Builds an OrderedList component.
     */
    public function orderedList(array $items): OrderedList
    {
        return $this->components[] = new OrderedList($items);
    }

    /**
     * Builds an UnorderedList component.
     */
    public function unorderedList(array $items): UnorderedList
    {
        return $this->components[] = new UnorderedList($items);
    }
}
