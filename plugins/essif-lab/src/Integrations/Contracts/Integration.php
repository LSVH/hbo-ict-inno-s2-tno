<?php

namespace TNO\EssifLab\Integrations\Contracts;

use TNO\EssifLab\Applications\Contracts\Application;
use TNO\EssifLab\ModelManagers\Contracts\ModelManager;
use TNO\EssifLab\ModelRenderers\Contracts\ModelRenderer;
use TNO\EssifLab\Utilities\Contracts\Utility;

interface Integration
{
    public function __construct(Application $application, ModelManager $manager, ModelRenderer $renderer, Utility $utility);

    public function install(): void;

    public function getApplication(): Application;

    public function getModelManager(): ModelManager;

    public function getUtility(): Utility;
}
