<?php

namespace TNO\EssifLab\Controllers;

defined('ABSPATH') or die();

use TNO\EssifLab\Abstracts\Controller;

class NotAdmin extends Controller {
	public function getActions(): array {
		return $this->actions;
	}

	public function getFilters(): array {
		return $this->filters;
	}
}