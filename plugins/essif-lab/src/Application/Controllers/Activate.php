<?php

<<<<<<< HEAD
namespace TNO\EssifLab\Application\Controllers;

defined('ABSPATH') or die();

use TNO\EssifLab\Contracts\Abstracts\SimpleController;
use TNO\EssifLab\Contracts\Interfaces\RegistersPostTypes;

class Activate extends SimpleController {
	public function execute(): void {
		$this->loadPostTypes();
	}

	private function loadPostTypes(): void {
		$this->getComponentWhatRegistersPostTypes()->registerPostTypes();
		flush_rewrite_rules();
	}

	private function getComponentWhatRegistersPostTypes(): RegistersPostTypes {
		return new Admin($this->getPluginData());
	}
=======
namespace TNO\Essiflab\Application\Controllers;

defined('ABSPATH') or die();

use TNO\EssifLab\Application\Workflows\Constructors\CoreAbstract;

class Activate extends CoreAbstract
{
>>>>>>> 32b6324... refactored plugin to conform to package diagram
}