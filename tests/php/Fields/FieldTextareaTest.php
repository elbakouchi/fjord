<?php

namespace FjordTest\Fields;

use Fjord\Crud\BaseField;
use FjordTest\BackendTestCase;
use Fjord\Crud\Fields\Textarea;
use FjordTest\Traits\InteractsWithFields;
use Fjord\Crud\Fields\Traits\FieldHasRules;
use Fjord\Crud\Fields\Traits\TranslatableField;

class FieldTextareaTest extends BackendTestCase
{
    use InteractsWithFields;

    public function setUp(): void
    {
        parent::setUp();

        $this->field = $this->getField(Textarea::class);
    }

    /** @test */
    public function it_can_have_rules()
    {
        $this->assertHasTrait(FieldHasRules::class, $this->field);
    }

    /** @test */
    public function it_can_be_translatable()
    {
        $this->assertHasTrait(TranslatableField::class, $this->field);
    }

    /** @test */
    public function it_is_base_field()
    {
        $this->assertInstanceOf(BaseField::class, $this->field);
    }

    /** @test */
    public function test_max_method()
    {
        $this->field->max(5);
        $this->assertArrayHasKey('max', $this->field->getAttributes());
        $this->assertEquals(5, $this->field->getAttribute('max'));

        // Assert method returns field instance.
        $this->assertEquals($this->field, $this->field->max(5));
    }
}
