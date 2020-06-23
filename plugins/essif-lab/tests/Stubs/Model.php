<?php

namespace TNO\EssifLab\Tests\Stubs;

use TNO\EssifLab\Constants;
use TNO\EssifLab\Models\Contracts\BaseModel;

class Model extends BaseModel
{
    protected $singular = 'model';

    protected $relations = [
        self::class,
    ];

<<<<<<< HEAD
	protected $fields = [
		Constants::FIELD_TYPE_SIGNATURE,
<<<<<<< HEAD
		Constants::FIELD_TYPE_SCHEMA_LOADER,
		Constants::FIELD_TYPE_IMMUTABLE,
=======
		Constants::FIELD_TYPE_CREDENTIAL_TYPE,
        Constants::FIELD_TYPE_IMMUTABLE
>>>>>>> fd9aad4... changed schema to credential type
	];
=======
    protected $fields = [
        Constants::FIELD_TYPE_SIGNATURE,
        Constants::FIELD_TYPE_CREDENTIAL_TYPE,
        Constants::FIELD_TYPE_IMMUTABLE,
    ];
>>>>>>> 44a9692... Applying patch StyleCI
}
