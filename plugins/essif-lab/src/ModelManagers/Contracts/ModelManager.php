<?php

namespace TNO\EssifLab\ModelManagers\Contracts;

use TNO\EssifLab\Applications\Contracts\Application;
use TNO\EssifLab\Models\Contracts\Model;
use TNO\EssifLab\Utilities\Contracts\Utility;

interface ModelManager
{
    public function __construct(Application $application, Utility $utility);

    public function insert(Model $model): int;

    public function delete(Model $model): bool;

    public function update(Model $model): int;

    public function select(Model $model, array $criteria = []): array;

    public function insertRelation(Model $from, Model $to): bool;

    public function deleteRelation(Model $from, Model $to): bool;

    public function deleteAllRelations(Model $model): bool;

    public function selectAllRelations(Model $from, Model $to): array;
}
