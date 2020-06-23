<?php

namespace TNO\EssifLab\Views\Items\Contracts;

interface Item
{
    public function __construct($value, string $label = null);

    public function getValue();

    public function getLabel(): string;

    public function canDisplayValue(): bool;
}
