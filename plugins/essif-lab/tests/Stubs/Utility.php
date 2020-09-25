<?php

namespace TNO\EssifLab\Tests\Stubs;

use TNO\EssifLab\Constants;
use TNO\EssifLab\Utilities\Contracts\BaseUtility;
use TNO\EssifLab\Utilities\WP;

<<<<<<< HEAD
class Utility extends BaseUtility {
	use WithHistory;

<<<<<<< HEAD
	static $meta = array();
=======
	static $meta = [];
>>>>>>> 85b8762... Added actions and filters for target and input.

	protected $callbackTriggeringFunctions = [
		WP::ADD_ACTION => [self::class, 'addHook'],
		WP::ADD_FILTER => [self::class, 'addHook'],
=======
class Utility extends BaseUtility
{
<<<<<<< HEAD
	use WithHistory;

	static $meta = [];

	protected $callbackTriggeringFunctions = [
		WP::ADD_ACTION   => [self::class, 'addHook'],
		WP::ADD_FILTER   => [self::class, 'addHook'],
>>>>>>> 8d3b645... Reformatted to editorconfig
		WP::ADD_META_BOX => [self::class, 'addMetaBox'],
	];

	protected $valueReturningFunctions = [
		BaseUtility::GET_CURRENT_MODEL => [self::class, 'getCurrentModel'],
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
        BaseUtility::GET_MODEL => [self::class, 'getModel'],
        BaseUtility::CREATE_MODEL_META => [self::class, 'createModelMeta'],
        BaseUtility::DELETE_MODEL_META => [self::class, 'deleteModelMeta'],
<<<<<<< HEAD
=======
		BaseUtility::GET_MODEL => [self::class, 'getModel'],
>>>>>>> 6a9c1f7... Fixed broken tests after refactoring
=======
		BaseUtility::GET_MODEL => [self::class, 'getModel'],
		BaseUtility::CREATE_MODEL_META => [self::class, 'createModelMeta'],
		BaseUtility::DELETE_MODEL_META => [self::class, 'deleteModelMeta'],
>>>>>>> 85b8762... Added actions and filters for target and input.
		BaseUtility::GET_MODEL_META => [self::class, 'getModelMeta'],
		BaseUtility::GET_MODELS => [self::class, 'getModels'],
	];

<<<<<<< HEAD
<<<<<<< HEAD
    function call(string $name, ...$parameters) {
		$wasCalled = count($this->getHistoryByFuncName($name));
		$this->history[] = new History($name, $parameters, $wasCalled + 1);
=======
	function call(string $name, ...$parameters) {
		$this->recordHistory($name, $parameters);
=======
        BaseUtility::GET_MODEL_META => [self::class, 'getModelMeta'],
        BaseUtility::GET_MODELS => [self::class, 'getModels'],
        BaseUtility::REGISTER_REST_ROUTE => [self::class, 'registerRestRoute'],
    ];
>>>>>>> ad9b665... moved register rest route to utilities to enable testing (by using a stub)

<<<<<<< HEAD
		if ($parameters[0] === 'essif-lab_insert_hook') {
			$parameters[1](['slug' => 'title']);
		}

		if ($parameters[0] === 'essif-lab_delete_hook') {
			$parameters[1](['slug' => 'title']);
		}
>>>>>>> 0b4d340... Added api for delete and insert hook
=======
		$this->handleSubPluginApi($name ,$parameters);
>>>>>>> 6a9c1f7... Fixed broken tests after refactoring
=======
	function call(string $name, ...$parameters) {
		$this->recordHistory($name, $parameters);

<<<<<<< HEAD
		$this->handleSubPluginApi($name, ...$parameters);
>>>>>>> 85b8762... Added actions and filters for target and input.

=======
>>>>>>> 2d59fe4... Fixed utillity stub
		if (array_key_exists($name, $this->callbackTriggeringFunctions)) {
			if (count($parameters) > 3) {
=======
		BaseUtility::GET_MODEL         => [self::class, 'getModel'],
		BaseUtility::CREATE_MODEL_META => [self::class, 'createModelMeta'],
		BaseUtility::UPDATE_MODEL_META => [self::class, 'updateModelMeta'],
		BaseUtility::DELETE_MODEL_META => [self::class, 'deleteModelMeta'],
		BaseUtility::GET_MODEL_META    => [self::class, 'getModelMeta'],
		BaseUtility::GET_MODELS        => [self::class, 'getModels'],
	];

	function call(string $name, ...$parameters)
	{
		$this->recordHistory($name, $parameters);

		if (array_key_exists($name, $this->callbackTriggeringFunctions))
		{
			if (count($parameters) > 3)
			{
>>>>>>> 8d3b645... Reformatted to editorconfig
				$this->handleSubPluginActions($name, ...$parameters);
			}

            $callback = $this->callbackTriggeringFunctions[$name];
            $callback(...$parameters);
		}

		if (array_key_exists($name, $this->valueReturningFunctions))
		{
			if (count($parameters) > 3)
			{
				$this->handleSubPluginFilters($name, ...$parameters);
			}

			$callback = $this->valueReturningFunctions[$name];

			return $callback(...$parameters);
		}

		return null;
	}

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
	static function handleSubPluginApi($name, array $params) {
		if ($name === 'add_action') {
			if ($params[0] === 'essif-lab_insert_hook') {
				$params[1](['slug' => 'title']);
			}

			if ($params[0] === 'essif-lab_delete_hook') {
				$params[1](['slug' => 'title']);
=======
	static function handleSubPluginApi($name, string $actionName, callable $actionHandler, ...$_) {
=======
	static function handleSubPluginActions($name, string $actionName, $actionHandler) {
>>>>>>> 2d59fe4... Fixed utillity stub
=======
	static function handleSubPluginActions($name, string $actionName, $actionHandler)
	{
>>>>>>> 8d3b645... Reformatted to editorconfig
		$prefix = 'essif-lab_';

		if ($name === 'add_action')
		{
			$hook = ['hook-slug' => 'Hook title'];
			$target = [1 => 'Target title'];
			$input = ['input-title' => 'Input title'];

			$commands = ['insert_', 'delete_'];
			$models = [
				'hook'   => [$hook],
				'target' => [$target, $hook],
				'input'  => [$input, $target],
			];

			foreach ($commands as $command)
			{
				foreach ($models as $model => $params)
				{
					if ($actionName === $prefix.$command.$model)
					{
						$actionHandler(...$params);
					}
				}
			}
		}
	}

	static function handleSubPluginFilters($name, string $actionName, $actionHandler)
	{
		$prefix = 'essif-lab_';

		if ($name === 'add_filter')
		{
			$command = $prefix.'select_';

			$items = [];
			$hookSlug = 'hook-slug';
			$targetSlug = '1-hook-slug';

			$models = [
				'hook'   => [$items],
				'target' => [$items, $hookSlug],
				'input'  => [$items, $targetSlug],
			];
			foreach ($models as $model => $params)
			{
				if ($actionName === $command.$model)
				{
					$actionHandler(...$params);
				}
>>>>>>> 85b8762... Added actions and filters for target and input.
			}
		}
	}

<<<<<<< HEAD
	static function addHook(string $hook, callable $callback, int $priority = 10, int $accepted_args = 1): void {
=======
	static function addHook(string $hook, callable $callback, int $priority = 10, int $accepted_args = 1): void
	{
>>>>>>> 8d3b645... Reformatted to editorconfig
		$params = range(0, $accepted_args);
		$callback(...$params);
	}

<<<<<<< HEAD
	static function addMetaBox($id, $title, $callback, $screen) {
		$callback();
	}

<<<<<<< HEAD
<<<<<<< HEAD
    static function getModel(int $id): Model {
        return self::createModelWithId($id);
    }
=======
	static function getModel(int $id): Model {
		return new Model([
			Constants::TYPE_INSTANCE_IDENTIFIER_ATTR => $id,
			Constants::TYPE_INSTANCE_TITLE_ATTR => 'hello',
			Constants::TYPE_INSTANCE_DESCRIPTION_ATTR => 'world',
		]);
	}
>>>>>>> 6a9c1f7... Fixed broken tests after refactoring
=======
	static function getModel(int $id): Model {
		return self::createModelWithId($id);
	}
>>>>>>> 85b8762... Added actions and filters for target and input.

	static function getCurrentModel(): Model {
		return self::createModelWithId(1);
	}

	static function createModelMeta(int $postId, string $key, $value): bool {
<<<<<<< HEAD
	    if (!isset(self::$meta[$postId])){
	        self::$meta[$postId] = array();
        }
	    if (!isset(self::$meta[$postId][$key])){
	        self::$meta[$postId][$key] = array();
        }
	    self::$meta[$postId][$key][] = $value;
	    return true;
    }

<<<<<<< HEAD
<<<<<<< HEAD
    static function deleteModelMeta(int $postId, string $key, $value = ''): bool {
        if (self::checkPostIdAndKey($postId, $key)){
            if (!empty($value)){
                if (($value_key = array_search($value, self::$meta[$postId][$key])) !== false){
=======
    static function updateModelMeta(int $postId, string $key, $value): bool
    {
        if (!isset(self::$meta[$postId])) {
            self::$meta[$postId] = array();
        }
        if (!isset(self::$meta[$postId][$key])) {
            self::$meta[$postId][$key] = array();
        }
        self::$meta[$postId][$key][] = $value;
        return true;
    }

=======
>>>>>>> 9f13c5b... removed unused methods
    static function deleteModelMeta(int $postId, string $key, $value = ''): bool
    {
        if (self::checkPostIdAndKey($postId, $key)) {
            if (!empty($value)) {
                if (($value_key = array_search($value, self::$meta[$postId][$key])) !== false) {
>>>>>>> cf9d98b... added immutable field to credentials
                    unset(self::$meta[$postId][$key][$value_key]);
                    return !in_array($value, self::$meta[$postId][$key]);
                }
            } else {
                self::$meta[$postId][$key] = array();
                return empty($meta[$postId][$key]);
            }
        }
        return false;
    }

	static function getModelMeta(int $postId, string $key): array {
	    if (isset(self::$meta) && isset(self::$meta[$postId]) && isset(self::$meta[$postId][$key])){
            return self::$meta[$postId][$key];
        }
=======
		if (! isset(self::$meta[$postId])) {
			self::$meta[$postId] = [];
		}
		if (! isset(self::$meta[$postId][$key])) {
=======
	static function addMetaBox($id, $title, $callback, $screen)
	{
		$callback();
	}

	static function getModel(int $id): Model
	{
		return self::createModelWithId($id);
	}

	static function getCurrentModel(): Model
	{
		return self::createModelWithId(1);
	}

	static function createModelMeta(int $postId, string $key, $value): bool
	{
		if (!isset(self::$meta[$postId]))
		{
			self::$meta[$postId] = [];
		}
		if (!isset(self::$meta[$postId][$key]))
		{
			self::$meta[$postId][$key] = [];
		}
		self::$meta[$postId][$key][] = $value;

		return true;
	}

	static function updateModelMeta(int $postId, string $key, $value): bool
	{
		if (!isset(self::$meta[$postId]))
		{
			self::$meta[$postId] = [];
		}
		if (!isset(self::$meta[$postId][$key]))
		{
>>>>>>> 8d3b645... Reformatted to editorconfig
			self::$meta[$postId][$key] = [];
		}
		self::$meta[$postId][$key][] = $value;

		return true;
	}

<<<<<<< HEAD
	static function deleteModelMeta(int $postId, string $key, $value = ''): bool {
		if (self::checkPostIdAndKey($postId, $key)) {
			if (! empty($value)) {
				if (($value_key = array_search($value, self::$meta[$postId][$key])) !== false) {
					unset(self::$meta[$postId][$key][$value_key]);

					return ! in_array($value, self::$meta[$postId][$key]);
				}
			} else {
=======
	static function deleteModelMeta(int $postId, string $key, $value = ''): bool
	{
		if (self::checkPostIdAndKey($postId, $key))
		{
			if (!empty($value))
			{
				if (($value_key = array_search($value, self::$meta[$postId][$key])) !== false)
				{
					unset(self::$meta[$postId][$key][$value_key]);

					return !in_array($value, self::$meta[$postId][$key]);
				}
			} else
			{
>>>>>>> 8d3b645... Reformatted to editorconfig
				self::$meta[$postId][$key] = [];

				return empty($meta[$postId][$key]) ? true : false;
			}
		}

		return false;
	}

<<<<<<< HEAD
	static function getModelMeta(int $postId, string $key): array {
		if (isset(self::$meta) && isset(self::$meta[$postId]) && isset(self::$meta[$postId][$key])) {
			return self::$meta[$postId][$key];
		}

>>>>>>> 85b8762... Added actions and filters for target and input.
		return [1];
	}

	static function getModels(array $args = []): array {
<<<<<<< HEAD
	    if (!empty($args) && !empty($args['post__in'])){
            return array_map(function($id) {
                return self::createModelWithId($id);
            }, $args['post__in']);
        }
        return [self::createModelWithId(1)];
    }

    static function createModelWithId($id): Model
    {
        return new Model([
            Constants::TYPE_INSTANCE_IDENTIFIER_ATTR => $id,
            Constants::TYPE_INSTANCE_TITLE_ATTR => 'hello',
            Constants::TYPE_INSTANCE_DESCRIPTION_ATTR => 'world'
=======
    use WithHistory;

    public static $meta = [];

    protected $callbackTriggeringFunctions = [
        WP::ADD_ACTION   => [self::class, 'addHook'],
        WP::ADD_FILTER   => [self::class, 'addHook'],
        WP::ADD_META_BOX => [self::class, 'addMetaBox'],
    ];

    protected $valueReturningFunctions = [
        BaseUtility::GET_CURRENT_MODEL            => [self::class, 'getCurrentModel'],
        BaseUtility::GET_MODEL                    => [self::class, 'getModel'],
        BaseUtility::CREATE_MODEL_META            => [self::class, 'createModelMeta'],
        BaseUtility::DELETE_MODEL_META            => [self::class, 'deleteModelMeta'],
        BaseUtility::GET_MODEL_META               => [self::class, 'getModelMeta'],
        BaseUtility::GET_MODELS                   => [self::class, 'getModels'],
        BaseUtility::REGISTER_GENERATE_JWT_ROUTE  => [self::class, 'registerGenerateJWTRoute'],
        BaseUtility::REGISTER_RECEIVE_JWT_ROUTE   => [self::class, 'registerReceiveJWTRoute'],
        BaseUtility::REGISTER_RETURN_INPUTS_ROUTE => [self::class, 'registerReturnInputsRoute'],
    ];

    public function call(string $name, ...$parameters)
    {
        $this->recordHistory($name, $parameters);

        if (array_key_exists($name, $this->callbackTriggeringFunctions)) {
            if (count($parameters) > 3) {
                $this->handleSubPluginActions($name, ...$parameters);
            }

            $callback = $this->callbackTriggeringFunctions[$name];
            $callback(...$parameters);
        }

        if (array_key_exists($name, $this->valueReturningFunctions)) {
            if (count($parameters) > 3) {
                $this->handleSubPluginFilters($name, ...$parameters);
            }

            $callback = $this->valueReturningFunctions[$name];

            return $callback(...$parameters);
        }

        return null;
    }

    public static function handleSubPluginActions($name, string $actionName, $actionHandler)
    {
        $prefix = 'essif-lab_';

        if ($name === 'add_action') {
            $hook = ['hook-slug' => 'Hook title'];
            $target = [1 => 'Target title'];
            $input = ['input-title' => 'Input title'];

            $commands = ['insert_', 'delete_'];
            $models = [
                'hook'   => [$hook],
                'target' => [$target, $hook],
                'input'  => [$input, $target],
            ];

            foreach ($commands as $command) {
                foreach ($models as $model => $params) {
                    if ($actionName === $prefix.$command.$model) {
                        $actionHandler(...$params);
                    }
                }
            }
        }
    }

    public static function handleSubPluginFilters($name, string $actionName, $actionHandler)
    {
        $prefix = 'essif-lab_';

        if ($name === 'add_filter') {
            $command = $prefix.'select_';

            $items = [];
            $hookSlug = 'hook-slug';
            $targetSlug = '1-hook-slug';

            $models = [
                'hook'   => [$items],
                'target' => [$items, $hookSlug],
                'input'  => [$items, $targetSlug],
            ];
            foreach ($models as $model => $params) {
                if ($actionName === $command.$model) {
                    $actionHandler(...$params);
                }
            }
        }
    }

    public static function addHook(string $hook, callable $callback, int $priority = 10, int $accepted_args = 1): void
    {
        $params = range(0, $accepted_args);
        $callback(...$params);
    }

    public static function addMetaBox($id, $title, $callback, $screen)
    {
        $callback();
    }

    public static function getModel(int $id): Model
    {
        return self::createModelWithId($id);
    }

    public static function getCurrentModel(): Model
    {
        return self::createModelWithId(1);
    }

    public static function createModelMeta(int $postId, string $key, $value): bool
    {
        if (!isset(self::$meta[$postId])) {
            self::$meta[$postId] = [];
        }
        if (!isset(self::$meta[$postId][$key])) {
            self::$meta[$postId][$key] = [];
        }
        self::$meta[$postId][$key][] = $value;

        return true;
    }

    public static function updateModelMeta(int $postId, string $key, $value): bool
    {
        if (!isset(self::$meta[$postId])) {
            self::$meta[$postId] = [];
        }
        if (!isset(self::$meta[$postId][$key])) {
            self::$meta[$postId][$key] = [];
        }
        self::$meta[$postId][$key][] = $value;

        return true;
    }

    public static function deleteModelMeta(int $postId, string $key, $value = ''): bool
    {
        if (self::checkPostIdAndKey($postId, $key)) {
            $value_key = array_search(empty($value) ? [] : $value, self::$meta[$postId][$key]);
            if ($value_key) {
                unset(self::$meta[$postId][$key][$value_key]);

                return !in_array($value, self::$meta[$postId][$key]);
            }
            self::$meta[$postId][$key] = [];

            return empty($meta[$postId][$key]);
        }

        return false;
    }

    public static function getModelMeta(int $postId, string $key): array
    {
        if (isset(self::$meta) && isset(self::$meta[$postId]) && isset(self::$meta[$postId][$key])) {
            return self::$meta[$postId][$key];
        }

        return [1];
    }

    public static function getModels(array $args = []): array
    {
        if (!empty($args) && !empty($args['post__in'])) {
            return array_map(function ($id) {
                return self::createModelWithId($id);
            }, $args['post__in']);
        }

        return [self::createModelWithId(1)];
    }

    public static function createModelWithId($id): Model
    {
        return new Model([
            Constants::TYPE_INSTANCE_IDENTIFIER_ATTR  => $id,
            Constants::TYPE_INSTANCE_TITLE_ATTR       => 'hello',
            Constants::TYPE_INSTANCE_DESCRIPTION_ATTR => 'world',
>>>>>>> 44a9692... Applying patch StyleCI
        ]);
    }

    private static function checkPostIdAndKey(int $postId, string $key): bool
    {
        return isset(self::$meta) && isset(self::$meta[$postId]) && isset(self::$meta[$postId][$key]);
    }

<<<<<<< HEAD
    public function clearMeta(): void {
	    self::$meta = array();
    }
<<<<<<< HEAD
=======
		if (! empty($args) && ! empty($args['post__in'])) {
=======
	static function getModelMeta(int $postId, string $key): array
	{
		if (isset(self::$meta) && isset(self::$meta[$postId]) && isset(self::$meta[$postId][$key]))
		{
			return self::$meta[$postId][$key];
		}

		return [1];
	}

	static function getModels(array $args = []): array
	{
		if (!empty($args) && !empty($args['post__in']))
		{
>>>>>>> 8d3b645... Reformatted to editorconfig
			return array_map(function ($id) {
				return self::createModelWithId($id);
			}, $args['post__in']);
		}

		return [self::createModelWithId(1)];
	}

<<<<<<< HEAD
	static function createModelWithId($id): Model {
		return new Model([
			Constants::TYPE_INSTANCE_IDENTIFIER_ATTR => $id,
			Constants::TYPE_INSTANCE_TITLE_ATTR => 'hello',
=======
	static function createModelWithId($id): Model
	{
		return new Model([
			Constants::TYPE_INSTANCE_IDENTIFIER_ATTR  => $id,
			Constants::TYPE_INSTANCE_TITLE_ATTR       => 'hello',
>>>>>>> 8d3b645... Reformatted to editorconfig
			Constants::TYPE_INSTANCE_DESCRIPTION_ATTR => 'world',
		]);
	}

<<<<<<< HEAD
	private static function checkPostIdAndKey(int $postId, string $key): bool {
		return isset(self::$meta) && isset(self::$meta[$postId]) && isset(self::$meta[$postId][$key]);
	}

	public function clearMeta(): void {
		self::$meta = [];
	}
>>>>>>> 85b8762... Added actions and filters for target and input.
}
=======
	private static function checkPostIdAndKey(int $postId, string $key): bool
	{
		return isset(self::$meta) && isset(self::$meta[$postId]) && isset(self::$meta[$postId][$key]);
	}

	public function clearMeta(): void
	{
		self::$meta = [];
	}
}
>>>>>>> 8d3b645... Reformatted to editorconfig
=======

    static function registerRestRoute() : bool {
	    return true;
=======
    public function clearMeta(): void
    {
        self::$meta = [];
    }

    public static function registerGenerateJWTRoute(): bool
    {
        return true;
    }

    public static function registerReceiveJWTRoute(): bool
    {
        return true;
>>>>>>> 44a9692... Applying patch StyleCI
    }

    public static function registerReturnInputsRoute(): bool
    {
        return true;
    }
}
>>>>>>> ad9b665... moved register rest route to utilities to enable testing (by using a stub)
