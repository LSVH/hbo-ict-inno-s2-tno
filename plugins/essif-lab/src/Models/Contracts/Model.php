<?php

namespace TNO\EssifLab\Models\Contracts;

interface Model
{
    public function __construct($attrs = []);

    public function getSingularName(): string;

    public function getPluralName(): string;

    public function getTypeName(): string;

    public function getTypeArgs(): array;

    public function getAttributes(): array;

    public function getAttributeNames(): array;

    public function getFields(): array;

    public function getRelations(): array;
}
