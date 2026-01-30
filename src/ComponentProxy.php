<?php

namespace LucasDavies\WikitextBuilder;

use LucasDavies\WikitextBuilder\Components\Component;

/**
 * A proxy that wraps a component and allows for immediate rendering
 * without adding the component to the builder's internal array.
 *
 * @template T of Component
 *
 * @mixin T
 */
class ComponentProxy
{
    /**
     * @param T $component
     */
    public function __construct(
        private Component $component,
        private Builder   $builder,
    )
    {
    }

    public function __toString(): string
    {
        return $this->render();
    }

    /**
     * Renders the component immediately and removes it from the builder's array.
     */
    public function render(): string
    {
        $this->builder->removeComponent($this->component);

        return $this->component->render();
    }

    /**
     * Removes the component from the builder's array without rendering.
     *
     * @internal
     */
    public function detach(): static
    {
        $this->builder->removeComponent($this->component);

        return $this;
    }

    /**
     * Delegates method calls to the underlying component.
     *
     * @return $this|mixed
     */
    public function __call(string $name, array $arguments): mixed
    {
        $result = $this->component->$name(...$arguments);

        // If the method returns the component (fluent chaining), return the proxy instead
        if ($result === $this->component) {
            return $this;
        }

        return $result;
    }
}
