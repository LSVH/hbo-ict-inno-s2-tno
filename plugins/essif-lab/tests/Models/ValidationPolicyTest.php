<?php

namespace TNO\EssifLab\Tests\Models;

use TNO\EssifLab\Constants;
use TNO\EssifLab\Models\Credential;
use TNO\EssifLab\Models\Target;
use TNO\EssifLab\Models\ValidationPolicy;
use TNO\EssifLab\Tests\TestCase;

class ValidationPolicyTest extends TestCase
{
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = new ValidationPolicy();
    }

    /** @test */
    public function does_generate_type_name_correctly(): void
    {
        $actual = $this->subject->getTypeName();

        $expected = 'validation-policy';

        $this->assertEquals($expected, $actual);
    }

    /** @test */
    public function should_not_hide_from_nav(): void
    {
        $actual = $this->subject->getTypeArgs();

        $this->assertIsArray($actual);
        $this->assertFalse($actual[Constants::TYPE_ARG_HIDE_FROM_NAV]);
    }

    /** @test */
    public function should_have_attribute_names(): void
    {
        $actual = $this->subject->getAttributeNames();

        $expected = Constants::TYPE_DEFAULT_ATTRIBUTE_NAMES;

        $this->assertEquals($expected, $actual);
    }

    /** @test */
    public function should_have_relations(): void
    {
        $actual = $this->subject->getRelations();

<<<<<<< HEAD
		$expected = [
<<<<<<< HEAD
			Hook::class,
			Credential::class,
=======
			Target::class,
			Credential::class
>>>>>>> ad9b665... moved register rest route to utilities to enable testing (by using a stub)
		];
=======
        $expected = [
            Target::class,
            Credential::class,
        ];
>>>>>>> 44a9692... Applying patch StyleCI

        $this->assertEquals($expected, $actual);
    }

    /** @test */
    public function should_have_fields(): void
    {
        $actual = $this->subject->getFields();

        $expected = Constants::TYPE_DEFAULT_FIELDS;

        $this->assertEquals($expected, $actual);
    }
}
