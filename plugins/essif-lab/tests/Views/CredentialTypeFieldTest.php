<?php

namespace TNO\EssifLab\Tests\Views;

use TNO\EssifLab\Tests\TestCase;
use TNO\EssifLab\Views\CredentialTypeField;

class CredentialTypeFieldTest extends TestCase {
	/** @test */
	function does_render_with_name_attr() {
		$subject = new CredentialTypeField($this->integration, $this->model);

		$actual = $subject->render();
		$expect = '/name="namespace\[credential type]/';

		$this->assertRegExp($expect, $actual);
	}
}