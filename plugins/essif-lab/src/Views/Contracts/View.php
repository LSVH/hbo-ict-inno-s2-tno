<?php

namespace TNO\EssifLab\Views\Contracts;

use TNO\EssifLab\Integrations\Contracts\Integration;
use TNO\EssifLab\Models\Contracts\Model;

interface View
{
    public function __construct(Integration $integration, Model $model, array $items = []);

    public function render(): string;
}
