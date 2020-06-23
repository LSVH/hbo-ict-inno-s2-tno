<?php

namespace TNO\ContactForm7\Integrations\Contracts;

use TNO\ContactForm7\Applications\Contracts\Application;
use TNO\ContactForm7\Utilities\Contracts\Utility;

abstract class BaseIntegration implements Integration
{
    protected $application;

    protected $manager;

    protected $renderer;

    protected $utility;

    public function __construct(Application $application, Utility $utility)
    {
        $this->application = $application;
        $this->utility = $utility;
    }

    public function getApplication(): Application
    {
        return $this->application;
    }

    public function getUtility(): Utility
    {
        return $this->utility;
    }
}
