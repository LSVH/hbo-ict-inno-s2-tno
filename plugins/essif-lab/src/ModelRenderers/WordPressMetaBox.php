<?php

namespace TNO\EssifLab\ModelRenderers;

use TNO\EssifLab\Integrations\Contracts\Integration;
use TNO\EssifLab\Models\Contracts\Model;
<<<<<<< HEAD
use TNO\EssifLab\Views\ImmutableField;
use TNO\EssifLab\Views\SchemaLoaderField;
=======
use TNO\EssifLab\Views\CredentialTypeField;
>>>>>>> fd9aad4... changed schema to credential type
use TNO\EssifLab\Views\SignatureField;
use TNO\EssifLab\Views\TypeList;

class WordPressMetaBox implements Contracts\ModelRenderer
{
	function renderListAndFormView(Integration $integration, Model $model, array $attrs = []): string
	{
		$view = new TypeList($integration, $model, $attrs);

		return $view->render();
	}

	function renderFieldSignature(Integration $integration, Model $model, array $attrs = []): string
	{
		$view = new SignatureField($integration, $model, $attrs);

		return $view->render();
	}

<<<<<<< HEAD
	function renderSchemaLoader(Integration $integration, Model $model, array $attrs = []): string
	{
		$view = new SchemaLoaderField($integration, $model, $attrs);

=======
	function renderCredentialType(Integration $integration, Model $model, array $attrs = []): string {
		$view = new CredentialTypeField($integration, $model, $attrs);
>>>>>>> fd9aad4... changed schema to credential type
		return $view->render();
	}

	function renderFieldImmutable(Integration $integration, Model $model, array $attrs = []): string
	{
		$view = new ImmutableField($integration, $model, $attrs);

		return $view->render();
	}
}
