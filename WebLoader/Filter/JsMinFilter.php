<?php

/**
 * This file is part of Nepttune (https://www.peldax.com)
 *
 * Copyright (c) 2018 Václav Pelíšek (info@peldax.com)
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <https://www.peldax.com>.
 */

declare(strict_types = 1);

namespace WebLoader\Filter;

use \WebLoader\Compiler;

class JsMinFilter
{
    public function __invoke(string $code, \WebLoader\Compiler $compiler, string $path) : string
    {
        $minifier = new \WebLoader\Minifier\JsMinifier($path);
        return $minifier->minify();
    }
}
