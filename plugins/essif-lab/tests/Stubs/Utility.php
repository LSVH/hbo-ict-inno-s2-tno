<?php

namespace TNO\EssifLab\Tests\Stubs;

use TNO\EssifLab\Constants;
use TNO\EssifLab\Utilities\Contracts\BaseUtility;
use TNO\EssifLab\Utilities\WP;

class Utility extends BaseUtility
{
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
        ]);
    }

    private static function checkPostIdAndKey(int $postId, string $key): bool
    {
        return isset(self::$meta) && isset(self::$meta[$postId]) && isset(self::$meta[$postId][$key]);
    }

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
    }

    public static function registerReturnInputsRoute(): bool
    {
        return true;
    }
}
