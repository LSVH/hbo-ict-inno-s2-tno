<?php

namespace TNO\EssifLab\Integrations;

use ReflectionClass;
use TNO\EssifLab\Constants;
use TNO\EssifLab\Integrations\Contracts\BaseIntegration;
use TNO\EssifLab\ModelManagers\Exceptions\UnknownModel;
use TNO\EssifLab\Models\Hook;
use TNO\EssifLab\Models\Input;
use TNO\EssifLab\Models\Target;
use TNO\EssifLab\Utilities\WP;

class WordPressSubPluginApi extends BaseIntegration
{
<<<<<<< HEAD
	const TRIGGER_PRE = 'essif-lab_';

	const PARAMS = 'params';

	const RELATION = 'relation';

	const TRIGGER_TYPES = [
		Hook::class   => [self::PARAMS => 1],
		Target::class => [self::PARAMS => 2, self::RELATION => Hook::class],
		Input::class  => [self::PARAMS => 2, self::RELATION => Target::class],
	];

	function install(): void
	{
		foreach (self::TRIGGER_TYPES as $type => $args)
		{
			$params = $args[self::PARAMS];
			$this->addActionInsert($type, $params);
			$this->addActionDelete($type, $params);
			if ($params === 2)
			{
				$this->applyFilterSelectAllRelations($type, $args[self::RELATION]);
			} else
			{
				$this->applyFilterSelect($type);
			}
		}
	}

<<<<<<< HEAD
	private function addActionInsert(string $instance, int $params)
	{
=======
	// TODO: figure out why this action is immediately executed instead of waiting for the trigger
	private function addActionInsert(string $instance, int $params) {
>>>>>>> d3c3c95... added some todo's
		$triggerName = self::getTriggerName(self::TRIGGER_PRE.'insert_', $instance);
		$this->utility->call(WP::ADD_ACTION, $triggerName, function (...$params) use ($instance) {
			if (self::isArrayOfArrays($params))
			{
				$instance = new $instance(self::getProps($params));
=======
    const TRIGGER_PRE = 'essif-lab_';

    const PARAMS = 'params';

    const RELATION = 'relation';

    const TRIGGER_TYPES = [
        Hook::class   => [self::PARAMS => 1],
        Target::class => [self::PARAMS => 2, self::RELATION => Hook::class],
        Input::class  => [self::PARAMS => 2, self::RELATION => Target::class],
    ];

    public function install(): void
    {
        foreach (self::TRIGGER_TYPES as $type => $args) {
            $params = $args[self::PARAMS];
            $this->addActionInsert($type, $params);
            $this->addActionDelete($type, $params);
            if ($params === 2) {
                $this->applyFilterSelectAllRelations($type, $args[self::RELATION]);
            } else {
                $this->applyFilterSelect($type);
            }
        }

        $this->applyFilterGenerateJti();
    }

    // TODO: figure out why this action is immediately executed instead of waiting for the trigger
    private function addActionInsert(string $instance, int $params)
    {
        $triggerName = self::getTriggerName(self::TRIGGER_PRE.'insert_', $instance);
        $this->utility->call(WP::ADD_ACTION, $triggerName, function (...$params) use ($instance) {
            if (self::isArrayOfArrays($params)) {
                $instance = new $instance(self::getProps($params));
>>>>>>> 44a9692... Applying patch StyleCI

                $instanceId = $this->manager->insert($instance);

                if (!($instance instanceof Hook)) {
                    $instanceAttrs = $instance->getAttributes();
                    $instanceAttrs[Constants::TYPE_INSTANCE_IDENTIFIER_ATTR] = $instanceId;
                    $instance->setAttributes($instanceAttrs);

                    $relatedModelId = null;
                    if ($instance instanceof Target) {
                        $relatedModelId = $this->manager->select(new Hook(), [WP::POST_NAME => $params[1]])[0];
                    } elseif ($instance instanceof Input) {
                        $relatedModelId = $this->manager->select(new Target(), [WP::POST_NAME => $params[1]])[0];
                    } else {
                        throw new UnknownModel(get_class($instance));
                    }

                    $this->manager->insertRelation($instance, $relatedModelId);
                }
<<<<<<< HEAD
			}
		}, 1, $params);
	}

	private function addActionDelete(string $model, int $params)
	{
		$triggerName = self::getTriggerName(self::TRIGGER_PRE.'delete_', $model);
		$this->utility->call(WP::ADD_ACTION, $triggerName, function (...$params) use ($model) {
			if (self::isArrayOfArrays($params))
			{
				$props = self::getProps($params);
				$slug = $props[Constants::TYPE_INSTANCE_SLUG_ATTR];
				$instance = new $model($props);
				$instances = $this->manager->select($instance, ['post_name' => $slug]);

				$this->manager->delete(empty($instances) ? null : current($instances));
			}
		}, 1, $params);
	}

	private function applyFilterSelect(string $model)
	{
		$triggerName = self::getTriggerName(self::TRIGGER_PRE.'select_', $model);
		$this->utility->call(WP::ADD_FILTER, $triggerName, function ($items) use ($model) {
			return array_merge(is_array($items) ? $items : [], $this->manager->select(new $model()));
		}, 1, 1);
	}

<<<<<<< HEAD
	private function applyFilterSelectAllRelations(string $model, string $relation)
	{
=======
	private function applyFilterSelectAllRelations(string $model, string $relation) {
<<<<<<< HEAD
	    // TODO: Change trigger name to be different from applyFilterSelect
>>>>>>> d3c3c95... added some todo's
=======
>>>>>>> 8dceff8... fixed select hook by name
		$triggerName = self::getTriggerName(self::TRIGGER_PRE.'select_', $model);
		$this->utility->call(WP::ADD_FILTER, $triggerName, function ($items, $parentSlug) use ($model, $relation) {
			$items = is_array($items) ? $items : [];
			$parentInstances = $this->manager->select(new $relation(), ['name' => $parentSlug]);
			$from = empty ($parentInstances) ? null : current($parentInstances);

			if (empty($from))
			{
				return $items;
			}

			$relations = $this->manager->selectAllRelations($from, new $model());

			return array_merge($items, $relations);
		}, 1, 2);
	}

	private static function isArrayOfArrays(array $value): bool
	{
		return !empty(array_filter($value, 'is_array'));
	}

	private static function getTriggerName(string $prefix, string $model): string
	{
		return $prefix.strtolower((new ReflectionClass($model))->getShortName());
	}

	private static function getProps(array $models): array
	{
		return [
			Constants::TYPE_INSTANCE_SLUG_ATTR  => self::getSlug($models),
			Constants::TYPE_INSTANCE_TITLE_ATTR => self::getTitle($models),
		];
	}

<<<<<<< HEAD
	private static function getTitle(array $models): string
	{
		return strval(current(end($models)));
=======
	private static function getTitle(array $models): string {
        return strval(current(reset($models)));
>>>>>>> 3cb823f... fixed saving of inputs (still need to fix deactivation hook)
	}

<<<<<<< HEAD
	private static function getSlug(array $models): string
	{
		return implode('__', array_map(function (array $param) {
			return key($param);
		}, $models));
=======
	private static function getSlug(array $models): string {
<<<<<<< HEAD
	    return strval(key(end($models)));
//		return implode('__', array_map(function (array $param) {
//			return key($param);
//		}, $models));
>>>>>>> a4f0582... fixed activation hook
=======
	    return strval(key(reset($models)));
>>>>>>> 3cb823f... fixed saving of inputs (still need to fix deactivation hook)
	}
=======
            }
        }, 1, $params);
    }

    private function addActionDelete(string $model, int $params)
    {
        $triggerName = self::getTriggerName(self::TRIGGER_PRE.'delete_', $model);
        $this->utility->call(WP::ADD_ACTION, $triggerName, function (...$params) use ($model) {
            if (self::isArrayOfArrays($params)) {
                $props = self::getProps($params);
                $slug = $props[Constants::TYPE_INSTANCE_SLUG_ATTR];
                $instance = new $model($props);
                $instances = $this->manager->select($instance, ['post_name' => $slug]);

                $this->manager->delete(empty($instances) ? null : current($instances));
            }
        }, 1, $params);
    }

    private function applyFilterSelect(string $model)
    {
        $triggerName = self::getTriggerName(self::TRIGGER_PRE.'select_', $model);
        $this->utility->call(WP::ADD_FILTER, $triggerName, function ($items) use ($model) {
            return array_merge(is_array($items) ? $items : [], $this->manager->select(new $model()));
        }, 1, 1);
    }

    private function applyFilterSelectAllRelations(string $model, string $relation)
    {
        $triggerName = self::getTriggerName(self::TRIGGER_PRE.'select_', $model);
        $this->utility->call(WP::ADD_FILTER, $triggerName, function ($items, $parentSlug) use ($model, $relation) {
            $items = is_array($items) ? $items : [];
            $parentInstances = $this->manager->select(new $relation(), ['name' => $parentSlug]);
            $from = empty($parentInstances) ? null : current($parentInstances);

            if (empty($from)) {
                return $items;
            }

            $relations = $this->manager->selectAllRelations($from, new $model());

            return array_merge($items, $relations);
        }, 1, 2);
    }

    private function applyFilterGenerateJti() {
        $triggerName = self::TRIGGER_PRE.'generate_jti';
        $this->utility->call(WP::ADD_FILTER, $triggerName, function () {
            return uniqid();
        }, 1, 1);
    }

    private static function isArrayOfArrays(array $value): bool
    {
        return !empty(array_filter($value, 'is_array'));
    }

    private static function getTriggerName(string $prefix, string $model): string
    {
        return $prefix.strtolower((new ReflectionClass($model))->getShortName());
    }

    private static function getProps(array $models): array
    {
        return [
            Constants::TYPE_INSTANCE_SLUG_ATTR  => self::getSlug($models),
            Constants::TYPE_INSTANCE_TITLE_ATTR => self::getTitle($models),
        ];
    }

    private static function getTitle(array $models): string
    {
        return strval(current(reset($models)));
    }

    private static function getSlug(array $models): string
    {
        return strval(key(reset($models)));
    }
>>>>>>> 44a9692... Applying patch StyleCI
}
