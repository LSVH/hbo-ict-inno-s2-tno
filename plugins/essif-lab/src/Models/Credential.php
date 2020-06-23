<?php

namespace TNO\EssifLab\Models;

use TNO\EssifLab\Constants;
use TNO\EssifLab\Models\Contracts\BaseModel;

class Credential extends BaseModel
{
    protected $singular = 'credential';

    protected $fields = [
        Constants::FIELD_TYPE_IMMUTABLE,
    ];

<<<<<<< HEAD
	protected $relations = [
		Input::class,
		Issuer::class,
<<<<<<< HEAD
		Schema::class,
=======
		CredentialType::class
>>>>>>> fd9aad4... changed schema to credential type
	];
=======
    protected $relations = [
        Input::class,
        Issuer::class,
        CredentialType::class,
    ];
>>>>>>> 44a9692... Applying patch StyleCI
}
