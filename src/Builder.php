<?php

namespace LucasDavies\WikitextBuilder;

use Closure;
use LucasDavies\WikitextBuilder\Components\Table\Table;
use LucasDavies\WikitextBuilder\Components\Template\Template;

class Builder
{
    public function __construct()
    {
        //
    }

    public function heading(string $content, int $level): string
    {
        $repeater = str_repeat('=', $level);

        return sprintf('%s%s%s', $repeater, $content, $repeater);
    }

    public function template(string $name, array $params = []): Template
    {
        return new Template($name)->params($params);
    }

    public function table(Closure $closure): Table
    {
        return $closure(new Table());
    }
}
