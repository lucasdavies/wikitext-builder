<?php

namespace LucasDavies\WikitextBuilder;

use Closure;
use LucasDavies\WikitextBuilder\Components\Component;
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

    /**
     * Removes a component from the internal components array.
     *
     * @internal
     */
    public function removeComponent(Component $component): void
    {
        $this->components = array_filter($this->components, static fn($c): bool => $c !== $component);
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

        $components = $this->components;
        $this->components = [];

        return implode("\n", array_map(static fn($component): string => $component->render(), $components));
    }

    /**
     * Builds a Heading component.
     *
     * @return ComponentProxy<Heading>
     */
    public function heading(string $content, int $level): ComponentProxy
    {
        $component = new Heading($content, $level);
        $this->components[] = $component;

        return new ComponentProxy($component, $this);
    }

    /**
     * Builds a Template component.
     *
     * @return ComponentProxy<Template>
     */
    public function template(string $name, array $params = []): ComponentProxy
    {
        $component = new Template($name)->params($params);
        $this->components[] = $component;

        return new ComponentProxy($component, $this);
    }

    /**
     * Builds a Table component.
     *
     * @return ComponentProxy<Table>
     */
    public function table(Closure $closure): ComponentProxy
    {
        $component = $closure(new Table());
        $this->components[] = $component;

        return new ComponentProxy($component, $this);
    }

    /**
     * Builds an OrderedList component.
     *
     * @return ComponentProxy<OrderedList>
     */
    public function orderedList(array $items): ComponentProxy
    {
        $this->detachProxies($items);

        $component = new OrderedList($items);
        $this->components[] = $component;

        return new ComponentProxy($component, $this);
    }

    /**
     * Builds an UnorderedList component.
     *
     * @return ComponentProxy<UnorderedList>
     */
    public function unorderedList(array $items): ComponentProxy
    {
        $this->detachProxies($items);

        $component = new UnorderedList($items);
        $this->components[] = $component;

        return new ComponentProxy($component, $this);
    }

    /**
     * Detaches any ComponentProxy items from the builder's array.
     */
    private function detachProxies(array $items): void
    {
        foreach ($items as $item) {
            if ($item instanceof ComponentProxy) {
                $item->detach();
            }
        }
    }
}
