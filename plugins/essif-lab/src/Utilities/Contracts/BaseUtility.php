<?php

namespace TNO\EssifLab\Utilities\Contracts;

use TNO\EssifLab\Utilities\Exceptions\InvalidUtility;

<<<<<<< HEAD
abstract class BaseUtility implements Utility
{
<<<<<<< HEAD
=======
abstract class BaseUtility implements Utility {
<<<<<<< HEAD
    public const ADD_JWT_ENDPOINT = 'addJWTEndpoint';

>>>>>>> 452bd9f... Added JWT REST API Eindpoint & generateJWTToken function for proper structure
=======
>>>>>>> 521d457... Changed hook to target, adjusted View for name/id
	public const CREATE_MODEL = 'createModel';
=======
    public const CREATE_MODEL = 'createModel';
>>>>>>> 44a9692... Applying patch StyleCI

    public const UPDATE_MODEL = 'updateModel';

    public const DELETE_MODEL = 'deleteModel';

    public const GET_MODELS = 'getModels';

    public const GET_MODEL = 'getModel';

    public const GET_CURRENT_MODEL = 'getCurrentModel';

    public const CREATE_MODEL_TYPE = 'createModelType';

    public const CREATE_MODEL_META = 'createModelMeta';

<<<<<<< HEAD
<<<<<<< HEAD
	public const UPDATE_MODEL_META = 'updateModelMeta';

	public const DELETE_MODEL_META = 'deleteModelMeta';
=======
    public const DELETE_MODEL_META = 'deleteModelMeta';
>>>>>>> 9f13c5b... removed unused methods
=======
    public const UPDATE_MODEL_META = 'updateModelMeta';

    public const DELETE_MODEL_META = 'deleteModelMeta';
>>>>>>> 44a9692... Applying patch StyleCI

    public const GET_MODEL_META = 'getModelMeta';

    public const GET_EDIT_MODEL_LINK = 'getEditModelLink';

    public const GET_CREATE_MODEL_LINK = 'getCreateModelLink';

    public const REGISTER_GENERATE_JWT_ROUTE = 'registerGenerateJWTRoute';

    public const REGISTER_RECEIVE_JWT_ROUTE = 'registerReceiveJWTRoute';

    public const REGISTER_RETURN_INPUTS_ROUTE = 'registerReturnInputsRoute';

    protected $functions = [];

<<<<<<< HEAD
	function __construct(array $functions = [])
	{
		$this->functions = array_merge([
<<<<<<< HEAD
			self::CREATE_MODEL          => [static::class, 'createModel'],
			self::UPDATE_MODEL          => [static::class, 'updateModel'],
			self::DELETE_MODEL          => [static::class, 'deleteModel'],
			self::GET_MODELS            => [static::class, 'getModels'],
			self::GET_MODEL             => [static::class, 'getModel'],
			self::GET_CURRENT_MODEL     => [static::class, 'getCurrentModel'],
			self::CREATE_MODEL_TYPE     => [static::class, 'createModelType'],
			self::CREATE_MODEL_META     => [static::class, 'createModelMeta'],
			self::UPDATE_MODEL_META     => [static::class, 'updateModelMeta'],
			self::DELETE_MODEL_META     => [static::class, 'deleteModelMeta'],
			self::GET_MODEL_META        => [static::class, 'getModelMeta'],
			self::GET_EDIT_MODEL_LINK   => [static::class, 'getEditModelLink'],
=======
			self::CREATE_MODEL => [static::class, 'createModel'],
			self::UPDATE_MODEL => [static::class, 'updateModel'],
			self::DELETE_MODEL => [static::class, 'deleteModel'],
			self::GET_MODELS => [static::class, 'getModels'],
			self::GET_MODEL => [static::class, 'getModel'],
			self::GET_CURRENT_MODEL => [static::class, 'getCurrentModel'],
			self::CREATE_MODEL_TYPE => [static::class, 'createModelType'],
			self::CREATE_MODEL_META => [static::class, 'createModelMeta'],
			self::DELETE_MODEL_META => [static::class, 'deleteModelMeta'],
			self::GET_MODEL_META => [static::class, 'getModelMeta'],
			self::GET_EDIT_MODEL_LINK => [static::class, 'getEditModelLink'],
>>>>>>> 9f13c5b... removed unused methods
			self::GET_CREATE_MODEL_LINK => [static::class, 'getCreateModelLink'],
            self::ADD_JWT_ENDPOINT => [static::class, 'addJWTEndpoint'],
            self::REGISTER_REST_ROUTE => [static::class, 'registerRestRoute'],
		], $this->functions, $functions);
	}

	function call(string $name, ...$parameters)
	{
		$function = $this->getFunctionByName($name);

		return $function(...$parameters);
	}

	private function getFunctionByName(string $name): callable
	{
		if ($this->isValidFunction($name))
		{
			throw new InvalidUtility($name);
		}

		return $this->functions[$name];
	}

	private function isValidFunction(string $name): bool
	{
		return !is_array($this->functions) || !array_key_exists($name,
				$this->functions) || !is_callable($this->functions[$name]);
	}
=======
    public function __construct(array $functions = [])
    {
        $this->functions = array_merge([
            self::CREATE_MODEL                 => [static::class, 'createModel'],
            self::UPDATE_MODEL                 => [static::class, 'updateModel'],
            self::DELETE_MODEL                 => [static::class, 'deleteModel'],
            self::GET_MODELS                   => [static::class, 'getModels'],
            self::GET_MODEL                    => [static::class, 'getModel'],
            self::GET_CURRENT_MODEL            => [static::class, 'getCurrentModel'],
            self::CREATE_MODEL_TYPE            => [static::class, 'createModelType'],
            self::CREATE_MODEL_META            => [static::class, 'createModelMeta'],
            self::UPDATE_MODEL_META            => [static::class, 'updateModelMeta'],
            self::DELETE_MODEL_META            => [static::class, 'deleteModelMeta'],
            self::GET_MODEL_META               => [static::class, 'getModelMeta'],
            self::GET_EDIT_MODEL_LINK          => [static::class, 'getEditModelLink'],
            self::GET_CREATE_MODEL_LINK        => [static::class, 'getCreateModelLink'],
            self::REGISTER_GENERATE_JWT_ROUTE  => [static::class, 'registerGenerateJWTRoute'],
            self::REGISTER_RECEIVE_JWT_ROUTE   => [static::class, 'registerReceiveJWTRoute'],
            self::REGISTER_RETURN_INPUTS_ROUTE => [static::class, 'registerReturnInputsRoute'],
        ], $this->functions, $functions);
    }

    public function call(string $name, ...$parameters)
    {
        $function = $this->getFunctionByName($name);

        return $function(...$parameters);
    }

    private function getFunctionByName(string $name): callable
    {
        if ($this->isValidFunction($name)) {
            throw new InvalidUtility($name);
        }

        return $this->functions[$name];
    }

    private function isValidFunction(string $name): bool
    {
        return !is_array($this->functions) || !array_key_exists(
            $name,
            $this->functions
        ) || !is_callable($this->functions[$name]);
    }
>>>>>>> 44a9692... Applying patch StyleCI
}
