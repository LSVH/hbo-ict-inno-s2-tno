<?php

namespace TNO\EssifLab\Integrations\Contracts;

use HaydenPierce\ClassFinder\ClassFinder;
use TNO\EssifLab\Applications\Contracts\Application;
use TNO\EssifLab\Constants;
use TNO\EssifLab\ModelManagers\Contracts\ModelManager;
use TNO\EssifLab\ModelRenderers\Contracts\ModelRenderer;
use TNO\EssifLab\Models\Contracts\Model;
use TNO\EssifLab\Utilities\Contracts\Utility;

abstract class BaseIntegration implements Integration
{
    protected $application;

    protected $manager;

    protected $renderer;

    protected $utility;

    public function __construct(Application $application, ModelManager $manager, ModelRenderer $renderer, Utility $utility)
    {
        $this->application = $application;
        $this->manager = $manager;
        $this->renderer = $renderer;
        $this->utility = $utility;
    }

    public function getApplication(): Application
    {
        return $this->application;
    }

    public function getModelManager(): ModelManager
    {
        return $this->manager;
    }

    public function getUtility(): Utility
    {
        return $this->utility;
    }

    protected static function forAllModels(callable $callback): void
    {
        $classNames = ClassFinder::getClassesInNamespace(Constants::TYPE_NAMESPACE);
        if (!empty($classNames)) {
            foreach ($classNames as $className) {
                if (self::isConcreteModel($className)) {
                    $instance = new $className();
                    $callback($instance);
                }
            }
        }
    }

    protected static function forEachModel(array $classNames, callable $callback): void
    {
        if (!empty($classNames)) {
            foreach ($classNames as $className) {
                if (self::isConcreteModel($className)) {
                    $instance = new $className();
                    $callback($instance);
                }
            }
        }
    }

    protected static function isConcreteModel(string $class): bool
    {
        return class_exists($class) && in_array(Model::class, class_implements($class));
    }
}
