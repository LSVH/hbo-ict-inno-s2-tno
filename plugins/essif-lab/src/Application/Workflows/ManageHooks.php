<?php

namespace TNO\EssifLab\Application\Workflows;

use TNO\EssifLab\Contracts\Abstracts\Workflow;

class ManageHooks extends Workflow {
	public static function options(): array {
		// TODO: load all selectable options to be displayed in the select lists.
		return ['context' => ['hello', 'world'], 'target' => ['foo', 'bar']];
	}

	public function add($request) {
		// TODO: add a hook to a validation policy
	}

	public function edit($request) {
		// TODO: edit a hook of a validation policy
	}

	public function delete($request) {
		// TODO: delete a hook of a validation policy
	}
}