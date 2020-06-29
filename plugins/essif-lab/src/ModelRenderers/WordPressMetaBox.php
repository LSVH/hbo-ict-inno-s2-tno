<?php

namespace TNO\EssifLab\ModelRenderers;

use TNO\EssifLab\Integrations\Contracts\Integration;
use TNO\EssifLab\Models\Contracts\Model;
use TNO\EssifLab\Views\CredentialTypeField;
use TNO\EssifLab\Views\ImmutableField;
use TNO\EssifLab\Views\SignatureField;
use TNO\EssifLab\Views\TypeList;

class WordPressMetaBox implements Contracts\ModelRenderer
{
    public function renderListAndFormView(Integration $integration, Model $model, array $attrs = []): string
    {
        $view = new TypeList($integration, $model, $attrs);

        return $view->render();
    }

    public function renderFieldSignature(Integration $integration, Model $model, array $attrs = []): string
    {
        $view = new SignatureField($integration, $model, $attrs);

        return $view->render();
    }

    public function renderCredentialType(Integration $integration, Model $model, array $attrs = []): string
    {
        $view = new CredentialTypeField($integration, $model, $attrs);

        return $view->render();
    }

    public function renderFieldImmutable(Integration $integration, Model $model, array $attrs = []): string
    {
        $view = new ImmutableField($integration, $model, $attrs);

        return $view->render();
    }
}
