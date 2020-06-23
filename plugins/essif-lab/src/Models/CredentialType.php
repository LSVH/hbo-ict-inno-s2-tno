<?php

namespace TNO\EssifLab\Models;

use TNO\EssifLab\Constants;
use TNO\EssifLab\Models\Contracts\BaseModel;

class CredentialType extends BaseModel
{
    protected $singular = 'credential type';

    protected $plural = 'credential types';

    protected $fields = [
        Constants::FIELD_TYPE_CREDENTIAL_TYPE,
    ];
}
