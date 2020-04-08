<?php

<<<<<<< HEAD
namespace TNO\Essiflab\Application\Controllers;

defined('ABSPATH') or die();

use TNO\EssifLab\Application\Workflows\Constructors\CoreAbstract;

class Deactivate extends CoreAbstract
{
    public function __construct(array $plugin_data = [])
    {
        parent::__construct($plugin_data);

        delete_option($this->get_domain());
        unregister_setting($this->get_plugin_parent_page(), $this->get_domain());
    }
=======
namespace TNO\EssifLab\Application\Controllers;

defined('ABSPATH') or die();

use TNO\EssifLab\Contracts\Abstracts\SimpleController;

class Deactivate extends SimpleController {
	public function execute(): void {
		// TODO: Implement execute() method.
	}
>>>>>>> 20c58e7... Fixed merge conflict issue
}