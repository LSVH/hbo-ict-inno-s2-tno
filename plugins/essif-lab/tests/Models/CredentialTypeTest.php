<?php

namespace TNO\EssifLab\Tests\Models;

use TNO\EssifLab\Constants;
use TNO\EssifLab\Models\CredentialType;
use TNO\EssifLab\Tests\TestCase;

<<<<<<< HEAD:plugins/essif-lab/tests/Models/SchemaTest.php
class SchemaTest extends TestCase
{
=======
class CredentialTypeTest extends TestCase {
>>>>>>> fd9aad4... changed schema to credential type:plugins/essif-lab/tests/Models/CredentialTypeTest.php
	protected $subject;

	protected function setUp(): void
	{
		parent::setUp();
		$this->subject = new CredentialType();
	}

	/** @test */
	function should_not_hide_from_nav(): void
	{
		$actual = $this->subject->getTypeArgs();

		$this->assertIsArray($actual);
		$this->assertFalse($actual[Constants::TYPE_ARG_HIDE_FROM_NAV]);
	}

	/** @test */
	function should_have_attribute_names(): void
	{
		$actual = $this->subject->getAttributeNames();

		$expected = Constants::TYPE_DEFAULT_ATTRIBUTE_NAMES;

		$this->assertEquals($expected, $actual);
	}

	/** @test */
	function should_have_no_relations(): void
	{
		$actual = $this->subject->getRelations();

		$expected = [];

		$this->assertEquals($expected, $actual);
	}

	/** @test */
	function should_have_fields(): void
	{
		$actual = $this->subject->getFields();

		$expected = array_merge(Constants::TYPE_DEFAULT_FIELDS, [
<<<<<<< HEAD:plugins/essif-lab/tests/Models/SchemaTest.php
			Constants::FIELD_TYPE_SCHEMA_LOADER,
=======
			Constants::FIELD_TYPE_CREDENTIAL_TYPE
>>>>>>> fd9aad4... changed schema to credential type:plugins/essif-lab/tests/Models/CredentialTypeTest.php
		]);

		$this->assertEquals($expected, $actual);
	}
}
