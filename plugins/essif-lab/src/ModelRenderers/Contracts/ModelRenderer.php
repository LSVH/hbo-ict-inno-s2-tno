<?php

namespace TNO\EssifLab\ModelRenderers\Contracts;

use TNO\EssifLab\Integrations\Contracts\Integration;
use TNO\EssifLab\Models\Contracts\Model;

interface ModelRenderer
{
    public function renderListAndFormView(Integration $integration, Model $model, array $attrs = []): string;

    public function renderFieldSignature(Integration $integration, Model $model, array $attrs = []): string;

    public function renderCredentialType(Integration $integration, Model $model, array $attrs = []): string;

    public function renderFieldImmutable(Integration $integration, Model $model, array $attrs = []): string;
}
