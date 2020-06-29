<?php

namespace TNO\EssifLab\Applications\Contracts;

interface Application
{
    public function getName(): string;

    public function getNamespace(): string;

    public function getAppDir(): string;
}
