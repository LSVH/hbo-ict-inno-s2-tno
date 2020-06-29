<?php

namespace TNO\EssifLab\Views\Items\Contracts;

abstract class BaseItem implements Item
{
    protected $value;

    protected $label;

    protected $canDisplayValue = true;

    public function __construct($value, string $label = null)
    {
        $this->value = $value;
        $this->label = $label;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getLabel(): string
    {
        $str = empty($this->label) && $this->canDisplayValue() ? $this->value : $this->label;
        $numericToString = is_numeric($str) ? strval($str) : '';

        return is_string($str) ? $str : $numericToString;
    }

    public function canDisplayValue(): bool
    {
        return $this->canDisplayValue;
    }

    public static function getByValue(array $items, $value): ?Item
    {
        $result = array_filter($items, function (Item $item) use ($value) {
            return $item->getValue() === $value;
        });

        return empty($result) ? null : $result[0];
    }

    public static function getByLabel(array $items, string $label): ?Item
    {
        $result = array_filter($items, function (Item $item) use ($label) {
            return $item->getLabel() === $label;
        });

        return empty($result) ? null : current($result);
    }
}
