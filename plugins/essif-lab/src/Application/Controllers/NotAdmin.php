<?php

<<<<<<< HEAD
namespace TNO\Essiflab\Application\Controllers;

defined('ABSPATH') or die();

use TNO\EssifLab\Application\Workflows\Constructors\CoreAbstract;

class NotAdmin extends CoreAbstract
{
    public function insert_message($content)
    {
        return $content .= '<p>'.esc_attr($this->get_option(self::FIELD_MESSAGE)).'</p>';
    }
=======
namespace TNO\EssifLab\Application\Controllers;

defined('ABSPATH') or die();

use TNO\EssifLab\Contracts\Abstracts\Controller;

class NotAdmin extends Controller {
	public function getActions(): array {
		return $this->actions;
	}

	public function getFilters(): array {
		return $this->filters;
	}
>>>>>>> 20c58e7... Fixed merge conflict issue
}