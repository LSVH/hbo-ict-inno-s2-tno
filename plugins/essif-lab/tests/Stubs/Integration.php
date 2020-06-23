<?php

namespace TNO\EssifLab\Tests\Stubs;

use TNO\EssifLab\Integrations\Contracts\BaseIntegration;
use TNO\EssifLab\Models\Contracts\Model;

class Integration extends BaseIntegration
{
    public function install(): void
    {
        // TODO: Implement install() method.
    }

    public function registerModelType(Model $model): void
    {
        // TODO: Implement registerModelType() method.
    }

    public function registerModelRelations(Model $model): void
    {
        // TODO: Implement registerModelRelations() method.
    }
}
