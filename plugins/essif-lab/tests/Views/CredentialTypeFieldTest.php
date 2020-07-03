<?php

namespace TNO\EssifLab\Tests\Views;

use TNO\EssifLab\Constants;
use TNO\EssifLab\Tests\Stubs\Model;
use TNO\EssifLab\Tests\TestCase;
use TNO\EssifLab\Views\CredentialTypeField;

class CredentialTypeFieldTest extends TestCase
{
    /** @test */
    public function does_render_input()
    {
        $subject = new CredentialTypeField($this->integration, $this->model);

        $actual = $subject->render();
        $expect = '/<input.*\/>/';

        $this->assertRegExp($expect, $actual);
    }

    /** @test */
    public function does_render_with_name_attr()
    {
        $subject = new CredentialTypeField($this->integration, $this->model);

        $actual = $subject->render();
        $expect = '/name="namespace\[credential_type]/';

        $this->assertRegExp($expect, $actual);
    }

    /** @test */
    public function does_render_with_signature_value()
    {
        $subject = new CredentialTypeField($this->integration, new Model([
            Constants::TYPE_INSTANCE_DESCRIPTION_ATTR => json_encode([
                Constants::FIELD_TYPE_CREDENTIAL_TYPE => 'hello world',
            ]),
        ]));

        $actual = $subject->render();
        $expect = '/value="hello world"/';

        $this->assertRegExp($expect, $actual);
    }
}
