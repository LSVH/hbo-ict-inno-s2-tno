<?php

namespace TNO\EssifLab\Utilities\Contracts;

interface Utility
{
    public function __construct(array $functions = []);

    public function call(string $name, ...$parameters);
}
